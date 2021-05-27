<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Section;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        return $this->redirect($routeBuilder->setController(TopicCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Forum - Административная панель')
            ->setFaviconPath('icons/favicon.png');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl(
            'Вернуться на сайт',
            'fas fa-angle-double-left',
            $this->generateUrl('app_home', [], true)
        );
        yield MenuItem::section();
        yield MenuItem::linkToCrud('Разделы', 'fas fa-list', Section::class);
        yield MenuItem::linkToCrud('Пользователи', 'fas fa-user-circle', User::class);
        yield MenuItem::linkToCrud('Комментарии', 'fas fa-comment', Comment::class);
    }
}
