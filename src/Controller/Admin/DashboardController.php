<?php
namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Testimonial;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\TestimonialCrudController;
use App\Entity\Project;
use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {

     return $this->render('admin/dashboard.html.twig');
     
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('Amd37');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Avis', 'fas fa-comment', Testimonial::class);
        yield MenuItem::linkToCrud('Contacts', 'fas fa-envelope', Contact::class);
        yield MenuItem::linkToCrud('Project', 'fas fa-envelope', Project::class);
        yield MenuItem::linkToCrud('Service', 'fas fa-envelope', Service::class);
    }
}