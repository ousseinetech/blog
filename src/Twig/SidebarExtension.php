<?php

namespace App\Twig;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SidebarExtension extends AbstractExtension
{
   protected $twig;
   protected $posts;
   protected $categories;
   protected $cache;

   public function __construct(
      Environment $twig,
      PostRepository $posts,
      CategoryRepository $categories,
      AdapterInterface $cache
   )
   {
      $this->posts = $posts;
      $this->twig = $twig;
      $this->categories = $categories;
      $this->cache = $cache;
   }

   public function getFunctions(): array
   {
      return [
         new TwigFunction('sidebar', [$this, 'getSidebar'], ['is_safe' => ['html']])
      ];
   }

   public function getSidebar()
   {
      return $this->cache->get('sidebar', function () {
         return $this->renderSidebar();
      });
   }

   private function renderSidebar(): string
   {
      return $this->twig->render('layout/sidebar.html.twig', [
         'posts' => $this->posts->findForSidebar(),
         'categories' => $this->categories->findAll()
      ]);
   }
}