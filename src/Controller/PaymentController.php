<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Stripe\Stripe;
use Stripe\Webhook;
use App\Entity\Project;
use App\Entity\ProjectLogo;
use App\Entity\ProjectSite;
use App\Service\VivaWallet;
use App\Entity\ProjectReseaux;
use App\Service\StripePayment;
use App\Repository\UserRepository;
use App\Repository\AddressRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Kernel;
use App\Repository\ProjectLogoRepository;
use App\Repository\ProjectSiteRepository;
use App\Repository\ProjectReseauxRepository;
use DateTimeImmutable;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use EasyCorp\Bundle\EasyAdminBundle\Form\DataTransformer\StringToFileTransformer;

#[Route('/payment')]
class PaymentController extends AbstractController
{
    #[Route('/{id}&{type}', name: 'app_payment', methods: ['GET', 'POST'])]
    public function payment(int $id, string $type, AddressRepository $addressRepository, MailerInterface $mailer, ProjectRepository $projectRepository, ProjectLogoRepository $projectLogoRepository, ProjectReseauxRepository $projectReseauxRepository, ProjectSiteRepository $projectSiteRepository)
    {
        $stripe_secret = $this->getParameter('STRIPE_SECRET');
        $payment = new StripePayment($stripe_secret);

        $type = ["type" => $type]["type"];
        if ($type == "Libre") {
            $project = $projectRepository->find(["id" => $id]);
        } elseif ($type == "Logo") {
            $project = $projectLogoRepository->find(["id" => $id]);
        } elseif ($type == "Réseaux Sociaux") {
            $project = $projectReseauxRepository->find(["id" => $id]);
        } elseif ($type == "Site Internet") {
            $project = $projectSiteRepository->find(["id" => $id]);
        }

        $user = $this->getUser();
        // dd($address);
        $session = $payment->startPayment($project, $user);

        return new RedirectResponse($session->url);
    }

    #[Route('/success', name: 'success_url')]
    public function success(Request $request): Response
    {
        $sessionId = $request->query->get('session_id');
        $stripe_secret = $this->getParameter('STRIPE_SECRET');
        $stripe = new StripePayment($stripe_secret);
        // dd($stripe->findEvent($sessionId));
        $session = $stripe->findEvent($sessionId);

        return $this->render('payment/success.html.twig', [
            'sessionId' => $sessionId,
        ]);
    }

    #[Route('/annulation', name: 'cancel_url')]
    public function cancel(Request $request): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }

    #[Route('/ma-facture', name: 'pdf_facture')]
    public function facturePdf(Request $request): Response
    {
        $sessionId = $request->query->get('session_id');
        $stripe_secret = $this->getParameter('STRIPE_SECRET');
        $stripe = new StripePayment($stripe_secret);
        // dd($stripe->findEvent($sessionId));
        $session = $stripe->findEvent($sessionId);

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled', true);
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // dd($session);
        
        $html = $this->renderView('facture/template_pdf.html.twig', [
            'session' => $session,
            'date' => new DateTimeImmutable('now'),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("Facture.pdf", [
            "Attachment" => false
        ]);
    }

    #[Route('/webhook/stripe', name: 'webhook_stripe', methods: ['GET', 'POST'])]
    public function webhookStripe(Request $request, EntityManagerInterface $em, MailerInterface $mailer, UserRepository $userRepository)
    { 

        $stripe_secret = $this->getParameter('STRIPE_SECRET');
        \Stripe\Stripe::setApiKey($stripe_secret);
        
        $endpoint_secret = $this->getParameter('STRIPE_WEBHOOK');

        $payload = @file_get_contents('php://input');

        $header = 'Stripe-Signature';
        $signature = $request->headers->get($header);
        $stripeEvent = null;

        try {
            $stripeEvent = \Stripe\Webhook::constructEvent(
                $payload, $signature, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($stripeEvent->type) {
            case 'checkout.session.completed':                
                $type = $stripeEvent->data->object->metadata->project_type;
                $projectId = $stripeEvent->data->object->metadata->project_id;
                if ($type == "Libre") {
                    $project = $em->getRepository(Project::class)->find( $projectId);
                } elseif ($type == "Logo") {
                    $project = $em->getRepository(ProjectLogo::class)->find($projectId);
                } elseif ($type == "Réseaux Sociaux") {
                    $project = $em->getRepository(ProjectReseaux::class)->find($projectId);
                } elseif ($type == "Site Internet") {
                    $project = $em->getRepository(ProjectSite::class)->find($projectId);
                }
                $project->setSessionId($stripeEvent->data->object->id);
                $project->setStatut(true);

                $userId = $project->getUser()->getId();
                $user = $userRepository->findUserById($userId);
                $email = (new TemplatedEmail())
                    ->from('soustraitesmoi@gmail.com')
                    ->to('soustraitesmoi@gmail.com')
                    ->subject('Validation de paiement')
                    ->htmlTemplate('emails/payment_validation.html.twig')
        
                    // pass variables (name => value) to the template
                    ->context([
                        'user' => $user,
                        'price' => $project->getPrice(),
                        'projectName' => $project->getNomDuProjet(),
                    ]);
                    
                $mailer->send($email);

                $em->persist($project);
                $em->flush();
                break;
            case 'invoice.paid':
                $customer = $stripeEvent->data->object;
                break;
            case 'invoice.payment_failed':
                $customer = $stripeEvent->data->object;
                break;
            // ... handle other event types
            default:
                throw new \Exception('Webhook non défini de la part de Stripe '.$stripeEvent->type);
        }
        return new Response(Response::HTTP_OK);
    }
}
