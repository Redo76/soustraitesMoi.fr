<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Entity\Image;
use App\Form\DevisFormType;
use App\Repository\DevisRepository;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;

class DevisController extends AbstractController
{
    #[Route('/devis', name: 'app_devis', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_EXPERT')]
    public function index(Request $request, SluggerInterface $slugger, UploaderHelper $uploaderHelper, DevisRepository $devisRepository, EntityManagerInterface $entityManager ): Response
    {
        $devis = new Devis($this->getUser());
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
        'devisForm'=>$form,
    ]);
}
}