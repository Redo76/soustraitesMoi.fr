<?php

namespace App\Security;

use App\Entity\User;
use League\OAuth2\Client\Provider\GoogleUser;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\HttpFoundation\Session\Flash\AutoExpireFlashBag;

class GoogleAuthenticator extends OAuth2Authenticator
{
    private ClientRegistry $clientRegistry;
    private EntityManagerInterface $entityManager;
    private RouterInterface $router;

    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $entityManager, RouterInterface $router)
    {
        $this->clientRegistry = $clientRegistry;
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    public function supports(Request $request): ?bool
    {
        // continue ONLY if the current ROUTE matches the check ROUTE
        return $request->attributes->get('_route') === 'connect_google_check';
    }

    public function authenticate(Request $request): Passport
    {
        $client = $this->clientRegistry->getClient('google');
        $accessToken = $this->fetchAccessToken($client);
        $session = $request->getSession();

        return new SelfValidatingPassport(
            new UserBadge($accessToken->getToken(), function () use ($accessToken, $client, $session) {
                /** @var GoogleUser $googleUser */
                $googleUser = $client->fetchUserFromToken($accessToken);

                $email = $googleUser->getEmail();
                // have they logged in with Google before? Easy!
                $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['googleId' => $googleUser->getId()]);

                if ($session->get('register')) {
                    //User doesnt exist, we create it !
                    if (!$existingUser) {
                        $existingUser = new User();
                        $existingUser->setEmail($email);
                        $existingUser->setFirstName($googleUser->getFirstName());
                        $existingUser->setLastName($googleUser->getLastName());
                        $existingUser->setGoogleId($googleUser->getId());
                        if ($session->get('register') == "client") {
                            $existingUser->setRoles(["ROLE_CLIENT"]);
                        } else {
                            $existingUser->setRoles(["ROLE_EXPERT"]);
                        }
                        $existingUser->setAvatar($googleUser->getAvatar());
                        $this->entityManager->persist($existingUser);
                        $this->entityManager->flush();
                    }
                }

                return $existingUser;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // change "app_dashboard" to some route in your app
        if ($request->getSession()->get('register') == "client") {
            return new RedirectResponse(
                $this->router->generate('app_register_clientInfo')
            );
        } else if ($request->getSession()->get('register') == "expert") {
            return new RedirectResponse(
                $this->router->generate('app_register_expertInfo')
            );
        } else {
            return new RedirectResponse(
                $this->router->generate('app_home')
            );
        }

        // or, on success, let the request continue to be handled by the controller
        // return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // $message = strtr($exception->getMessageKey(), $exception->getMessageData());
        // $mess = "pas de compte google";
        // $request->getSession()->getFlashBag()->add('error', "");

        return new RedirectResponse(
            $this->router->generate('app_register')
        );
    }

//    public function start(Request $request, AuthenticationException $authException = null): Response
//    {
//        /*
//         * If you would like this class to control what happens when an anonymous user accesses a
//         * protected page (e.g. redirect to /login), uncomment this method and make this class
//         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
//         *
//         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
//         */
//    }
}