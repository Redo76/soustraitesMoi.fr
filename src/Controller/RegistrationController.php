<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use App\Form\RegistrationInfoFormType;
use App\Form\RegistrationExpertFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function index(): Response
    {
        return $this->render('registration/register.html.twig', [
            'controller_name' => 'RegistrationController',
        ]);
    }
    #[Route('/inscription-client', name: 'app_register_client')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $request->getSession()->set('register', "client");

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                    )
                );
                
                // $isComp = $form["isCompany"]->getData();
                
                $user->setRoles(["ROLE_CLIENT"]);
                $user->setIsCompany($form->get('isCompany')->getData());

                $request->getSession()->remove('register');
                
                $entityManager->persist($user);
                $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/client_register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/inscription-client/info', name: 'app_register_clientInfo')]
    public function registerPLus(Request $request, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(RegistrationInfoFormType::class, $user);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $user->setIsCompany($form->get('isCompany')->getData());
            
            $request->getSession()->remove('register');
            $user = $form->getData();
            
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/client_register_info.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/inscription-expert', name: 'app_register_expert')]
    public function registerExpert(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $request->getSession()->set('register', "expert");
        
        $user = new User();
        $form = $this->createForm(RegistrationExpertFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $user->setRoles(["ROLE_EXPERT"]);
            $user->setIsCompany(true);

            $request->getSession()->remove('register');

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/expert_register.html.twig', [
            'registrationExpertForm' => $form->createView(),
        ]);
    }
}
