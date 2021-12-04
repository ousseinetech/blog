<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\BannerRepository;
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

    public function __construct(BannerRepository $banner, PostRepository $posts)
    {
       $this->banner = $banner;
       $this->posts = $posts;
    }

   /**
     * @Route("/blog", name="blog")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $posts = $paginator->paginate(
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
    public function post(Post $post): Response
    {
       return $this->render('main/blog/post.html.twig', [
          'post' => $post,
       ]);
    }
}
