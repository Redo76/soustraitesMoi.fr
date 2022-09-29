<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Form\EditProfileClientType;
use App\Form\EditProfileExpertType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    public function editInfos(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        // dd($user);
        $form = $this->createForm(EditProfileClientType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
