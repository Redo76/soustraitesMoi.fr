<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Devis;
use App\Entity\Image;
use App\Form\DevisFormType;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Types\DateType;
use App\Repository\DevisRepository;
use App\Repository\ImageRepository;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Http\RememberMe\ResponseListener;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DevisController extends AbstractController
{
    #[Route('/devis', name: 'app_devis', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_EXPERT')]
    public function index(Request $request, SluggerInterface $slugger, UploaderHelper $uploaderHelper, DevisRepository $devisRepository, AddressRepository $addressRepository , EntityManagerInterface $entityManager): Response
    {
        $user= $this->getUser();
        $devis = new Devis($user);
        if ($user->getAddress()) {
            $address_id = $user->getAddress()->getId();
            $address = $addressRepository->findAdressById($address_id);
    
            $devis->setAdresse($address);
        }

        $form = $this->createForm(DevisFormType::class, $devis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // essai upload
            $uploadedFiles = $form['Images']->getData();

            if ($uploadedFiles) {
                foreach ($uploadedFiles as $key => $uploadedFile) {
                    $newFilename = $uploaderHelper->uploadDevis($uploadedFile, $slugger);
                    $img = new Image();
                    $img->setName($newFilename);

                    $devis->addImage($img);
                }
                
            }

            $devis = $form->getData();

            $entityManager->persist($devis);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'votre devis a bien été enregistré'
            );
            return $this->redirectToRoute('app_home');
        }
        return $this->renderForm('devis/index.html.twig', [
            // 'devis' => $devis,
            'devisForm' => $form,
        ]);
    }


    // pdf devis Joffrine
    #[Route('/pdf-admin/{id}', name: 'devis_pdf_admin', methods: ['GET', 'POST'])]
    public function devisPdfAdmin(Request $request, AddressRepository $addressRepository, DevisRepository $devisRepository, int $id)
    {
        
        $devis = $devisRepository->findByDevisId($id); 
        $address_id = $devis["adresse_id"];
        $address = $addressRepository->findAdressById($address_id);

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('devis/pdfadmin.html.twig', [
            'devis' => $devis,
            'address' => $address,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("pdfadmin.pdf", [
            "Attachment" => false
        ]);
    }

    // test devis
    #[Route('/test', name: 'devis_test', methods: ['GET', 'POST'])]
    public function imprimedevis(Request $request, DevisRepository $devisRepository)
    {

        $devis = $devisRepository->tousDevis();
        return $this->render('devis/testdevis.html.twig', [
            'devis' => $devis,
        ]);
    }

//    test afficher image devis uploadé   
#[Route('/devis-upload/{id}', name: 'devis_upload', methods: ['GET', 'POST'])]
public function affichedevis(Request $request, DevisRepository $devisRepository,  int $id)
{

    $devis = $devisRepository->findByDevisUpload($id)['name'];
    return $this->render('devis/devisupload.html.twig', [
        'devis' => $devis,
    ]);
   
}

}