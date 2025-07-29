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
        // Retrieve the 3 most recently updated online projects
        $projects = $projectRepo->findBy(
            ['isOnline' => true],
            ['updatedAt' => 'DESC'],
            3
        );

        // Retrieve all testimonials, ordered by creation date (newest first)
        $testimonials = $testimonialRepository->findBy(
            [],
            ['createdAt' => 'DESC']
        );

        // Retrieve all services ordered by position (for custom display order)
        $services = $serviceRepo->findBy(
            [],
            ['position' => 'ASC']
        );

        // Render the homepage template with the fetched data
        return $this->render('home/index.html.twig', [
            'projects' => $projects,
            'testimonials' => $testimonials,
            'services' => $services,
        ]);
    }
}
