<?php

namespace App\Controller\Admin;

use App\Entity\About;
use App\Entity\Banner;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/blog/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(PostCrudController::class)->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setFaviconPath('favicon.svg')
            ->setTitle('BLOG');
    }

   public function configureMenuItems(): iterable
    {
       return [
          MenuItem::linkToRoute('Website', 'fa fa-home', 'home'),
          MenuItem::linkToCrud('About', 'fas fa-user', About::class),
          MenuItem::linkToCrud('Posts', 'fas fa-list', Post::class),
          MenuItem::linkToCrud('Categories', 'fas fa-tags', Category::class),
          MenuItem::linkToCrud('Commentaires', 'fas fa-comment', Comment::class),
          MenuItem::linkToCrud('Bannière', 'fas fa-images', Banner::class)
       ];
    }
}
