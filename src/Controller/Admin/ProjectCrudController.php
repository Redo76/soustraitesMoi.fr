<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/projets')]
class ProjectCrudController extends AbstractController
{
    #[Route('/', name: 'app_admin_projects', methods: ['GET'])]
    public function indexAll(ProjectRepository $projectRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $projects = $projectRepository->findAllProjects();

        $projectsPagination = $paginator->paginate(
            $projects, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('admin/valid_projects.html.twig', [
            'projects' => $projectsPagination,
        ]);
    }

    #[Route('/en-cours', name: 'app_admin_IpProjects', methods: ['GET'])]
    public function indexIP(ProjectRepository $projectRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $projects = $projectRepository->findAllInProgressProjects();

        $projectsPagination = $paginator->paginate(
            $projects, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('admin/in-progress_projects.html.twig', [
            'projects' => $projectsPagination,
        ]);
    }

    // #[Route('/{id}', name: 'app_article_crud_show', methods: ['GET'])]
    // public function show(Post $post): Response
    // {
    //     return $this->render('article_crud/show.html.twig', [
    //         'post' => $post,
    //     ]);
    // }

    // #[Route('/{id}/edit', name: 'app_article_crud_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Post $post, PostRepository $postRepository, SluggerInterface $slugger): Response
    // {
    //     $form = $this->createForm(ArticlePostType::class, $post);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $thumbnail = $form->get('thumbnail')->getData();
    //         if ($thumbnail) {
    //             $originalFilename = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
    //             $safeFilename = $slugger->slug($originalFilename);
    //             $newFilename = '../uploads/thumbnails/' . $safeFilename . '-' . uniqid() . '.' . $thumbnail->guessExtension();
    //             $thumbnail->move(
    //                 $this->getParameter('thumbnails_directory'),
    //                 $newFilename
    //             );
    //             $post->setThumbnail($newFilename);
    //         }

    //         $postRepository->add($post, true);

    //         return $this->redirectToRoute('app_article_crud_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('article_crud/edit.html.twig', [
    //         'post' => $post,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_article_crud_delete', methods: ['POST'])]
    // public function delete(Request $request, Post $post, PostRepository $postRepository): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
    //         $postRepository->remove($post, true);
    //     }

    //     return $this->redirectToRoute('app_article_crud_index', [], Response::HTTP_SEE_OTHER);
    // }
}