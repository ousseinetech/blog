<?php

namespace App\Controller;

use App\Repository\AboutRepository;
use App\Repository\BannerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/about", name="about")
     */
    public function index(AboutRepository $about, BannerRepository $banner): Response
    {
        return $this->render('main/about/index.html.twig', [
            'controller_name' => 'AboutController',
            'banner' => $banner->findOneBy(['name' => 'about']),
            'about' => $about->findOneBy(['id' => 1])
        ]);
    }
}
