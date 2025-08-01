<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use App\Repository\ServiceRepository;
use App\Repository\TestimonialRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * This controller handles the display of the homepage.
 */
class HomeController extends AbstractController
{
    /**
     * Homepage route displaying featured projects, services, and testimonials.
     *
     * @param ProjectRepository $projectRepo Repository to fetch online projects.
     * @param TestimonialRepository $testimonialRepository Repository to fetch testimonials.
     * @param ServiceRepository $serviceRepo Repository to fetch services.
     *
     * @return Response The rendered homepage.
     */
    #[Route('/', name: 'app_home')]
    public function index(
        ProjectRepository $projectRepo,
        TestimonialRepository $testimonialRepository,
        ServiceRepository $serviceRepo,
    ): Response
    {
        // Récupérer tous les projets en ligne
        $allOnlineProjects = $projectRepo->findBy(['isOnline' => true]);

        // Mélanger les projets aléatoirement
        shuffle($allOnlineProjects);

        // Prendre les 3 premiers
        $projects = array_slice($allOnlineProjects, 0, 3);

        // Récupérer tous les témoignages, triés par date de création descendante
        $testimonials = $testimonialRepository->findBy([], ['createdAt' => 'DESC']);

        // Récupérer tous les services triés par position
        $services = $serviceRepo->findBy([], ['position' => 'ASC']);

        // Renvoyer la vue avec les données
        return $this->render('home/index.html.twig', [
            'projects' => $projects,
            'testimonials' => $testimonials,
            'services' => $services,
        ]);
    }
}
