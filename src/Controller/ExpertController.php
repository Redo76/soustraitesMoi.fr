<?php

namespace App\Controller;

use App\Form\EditProfileExpertType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExpertController extends AbstractController
{
    #[Route('/mon-compte-expert', name: 'app_expert')]
    // #[IsGranted('ROLE_EXPERT')]
    // #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('profil_expert/index.html.twig', [
            'controller_name' => 'ExpertController',
        ]);
    }
    #[Route('/mon-compte-expert/modifier', name: 'app_edit_expert', methods : ['GET', 'POST'])]
    public function editInfos(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        // dd($user);
        $form = $this->createForm(EditProfileExpertType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_expert');
        }
        return $this->render('profil_expert/edit_infos.html.twig', [
            'controller_name' => 'ExpertController', 
            'EditExpert' =>$form->createView(),
        ]);
    }
}
