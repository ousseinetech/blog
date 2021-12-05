<?php

namespace App\Controller\Author;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog/author")
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/", name="blog_author_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('author/index.html.twig', [
            'posts' => $postRepository->findAllDesc(),
        ]);
    }

    /**
     * @Route("/new", name="blog_author_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('blog_author_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('author/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="blog_author_show", methods={"GET"})
     */
    public function show(Post $post): Response
    {
        return $this->render('author/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="blog_author_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('blog_author_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('author/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="blog_author_delete", methods={"POST"})
     */
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('blog_author_index', [], Response::HTTP_SEE_OTHER);
    }
}
