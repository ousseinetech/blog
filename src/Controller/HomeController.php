<?php

namespace App\Controller;

use App\Repository\BannerRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    protected $posts;
    protected $banners;

    public function __construct(PostRepository $posts, BannerRepository $banners)
    {
       $this->posts = $posts;
       $this->banners = $banners;
    }

   /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('main/home/index.html.twig', [
            'controller_name' => 'HomeController',
             'banner' => $this->banners->findOneBy(['name' => 'homepage']),
             'posts' => $this->posts->findLatest()
        ]);
    }
}
