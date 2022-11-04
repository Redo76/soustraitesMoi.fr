<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\EditProfileExpertType;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function editInfos(SluggerInterface $slugger, UploaderHelper $uploaderHelper, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        // dd($user);
        $form = $this->createForm(EditProfileExpertType::class, $user);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $user = new User();
            $uploadedFile = $form['avatar']->getData();
            $uploadedFile2 = $form['rib']->getData();

            if ($uploadedFile) {
                // dd($user);
                $newFilename = $uploaderHelper->uploadAvatar($uploadedFile, $slugger);
                $user = $form->getData();
                $user->setAvatar($newFilename);
            }
            if ($uploadedFile2) {
                $newFilename = $uploaderHelper->uploadRib($uploadedFile2, $slugger);
                $user = $form->getData();
                $user->setrib($newFilename);
            }
            else {
                $user = $form->getData();
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'votre profil a bien été modifié'
            );

            return $this->redirectToRoute('app_expert');
        }
        return $this->render('profil_expert/edit_infos.html.twig', [
            'controller_name' => 'ExpertController', 
            'EditExpert' =>$form->createView(),
        ]);
    }
    #[Route('/cv', name: 'app_cv_expert', methods : ['GET', 'POST'])]
    public function cvExpert(SluggerInterface $slugger, UploaderHelper $uploaderHelper, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileExpertType::class, $user);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $user = new User();
            $uploadedFile = $form['cv']->getData();

            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadCv($uploadedFile, $slugger);
                $user = $form->getData();
                $user->setcv($newFilename);
            }
            else {
                $user = $form->getData();
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'votre document a bien été enregistré'
            );

            return $this->redirectToRoute('app_expert');
        }
        return $this->render('profil_expert/cvexpert.html.twig', [
            'controller_name' => 'ExpertController', 
            'EditExpert' =>$form->createView(),
        ]);
    }

    // essai affichager tous les rib et expert correspondant
    #[Route('/rib', name: 'rib_expert', methods: ['GET', 'POST'])]
    public function afficherib(Request $request, UserRepository $userRepository)
    {

        $user = $userRepository->findAllRib();
        return $this->render('admin/ribexpert.html.twig', [
            // userS en prevision du { for user in users} dans template
            'users' => $user,
        ]);
    }

    //    test afficher à l'ecran rib uploadé   
    #[Route('/rib-upload/{id}', name: 'rib_upload', methods: ['GET', 'POST'])]
    public function affichedevis(Request $request, UserRepository $userRepository,  int $id)
    {

        $rib = $userRepository->findByribUpload($id)['rib'];
        return $this->render('admin/ribupload.html.twig', [
            'rib' => $rib,
        ]);
    }

    // essai affichager tous les cv et expert correspondant
    #[Route('/cv-admin', name: 'admin_cv_expert', methods: ['GET', 'POST'])]
    public function affichecv(Request $request, UserRepository $userRepository)
    {

        $user = $userRepository->findAllCv();
        return $this->render('admin/cvexpert.html.twig', [
            // userS en prevision du { for user in users} dans template
            'users' => $user,
        ]);
    }

    //    test afficher à l'ecran rib uploadé   
    #[Route('/cv-upload/{id}', name: 'cv_upload', methods: ['GET', 'POST'])]
    public function afficheCvUpload(Request $request, UserRepository $userRepository,  int $id)
    {

        $cv = $userRepository->findByCvUpload($id)['cv'];
        return $this->render('admin/cvupload.html.twig', [
            'cv' => $cv,
        ]);
    }
}
