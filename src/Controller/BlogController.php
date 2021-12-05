<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\BannerRepository;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    protected $posts;
    protected $banner;
    protected $paginator;

   public function __construct(
      BannerRepository $banner,
      PostRepository $posts,
      PaginatorInterface $paginator)
    {
       $this->banner = $banner;
       $this->posts = $posts;
       $this->paginator = $paginator;
    }

   /**
     * @Route("/blog", name="blog")
     */
    public function index(Request $request): Response
    {
        $posts = $this->paginator->paginate(
           $this->posts->findAllDesc(),
           $request->query->getInt('page', 1),
           12
        );

        return $this->render('main/blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'banner' => $this->banner->findOneBy(['name' => 'articles']),
            'posts' => $posts
        ]);
    }

   /**
    * @Route("/blog/post/{slug}", name="blog_post")
    */
    public function post(Post $post, Request $request): Response
    {
       $comment = new Comment();
       $comment->setPost($post);
       $comment->setPublishedAt(new \DateTimeImmutable());
       $form = $this->createForm(CommentType::class, $comment);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($comment);
          $em->flush();

          $this->addFlash('success', 'Votre commentaire est enregisterer avec succès !');
          return $this->redirectToRoute('blog_post', ['slug' => $post->getSlug()], Response::HTTP_SEE_OTHER);
       }

       return $this->render('main/blog/post.html.twig', [
          'post' => $post,
          'form' => $form->createView(),
       ]);
    }

   /**
    * @Route("/blog/category/{slug}", name="blog_category")
    */
    public function category(Category $category, Request $request): Response
    {
       $posts = $this->paginator->paginate(
          $category->getPosts(),
          $request->query->getInt('page', 1),
          12
       );

       return $this->render('main/blog/index.html.twig', [
          'banner' => $this->banner->findOneBy(['name' => 'articles']),
          'posts' => $posts
       ]);
    }
}
