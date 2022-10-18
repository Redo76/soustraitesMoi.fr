<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UploaderHelper;
use App\Repository\UserRepository;
use App\Form\EditProfileClientType;
use App\Form\EditProfileExpertType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    #[Route('/mon-compte-client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('profil_client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
    #[Route('/mon-compte-client/modifier', name: 'app_edit_client', methods : ['GET', 'POST'])]
    public function editInfos(Request $request, SluggerInterface $slugger, UploaderHelper $uploaderHelper, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        // dd($user);
        $form = $this->createForm(EditProfileClientType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $user = new User();
            $uploadedFile = $form['avatar']->getData();

            if ($uploadedFile) {
                // dd($user);
                $newFilename = $uploaderHelper->uploadAvatar($uploadedFile, $slugger);
                $user = $form->getData();
                $user->setAvatar($newFilename);
            }
            $user->setIsCompany($form->get('isCompany')->getData());
            $user = $form->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_client');
        }
        return $this->render('profil_client/edit_infos.html.twig', [
            'controller_name' => 'ClientController', 
            'EditClient' =>$form->createView(),
        ]);
    }
}
