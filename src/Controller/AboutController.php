<?php

namespace App\Controller;

use App\Repository\TestimonialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller responsible for displaying the "About" page.
 */
final class AboutController extends AbstractController
{
    /**
     * Displays the "About Us" page with a list of testimonials.
     *
     * @param TestimonialRepository $testimonialRepository The repository used to fetch testimonials.
     *
     * @return Response The rendered about page.
     */
    #[Route('/a-propos', name: 'app_about')]
    public function index(TestimonialRepository $testimonialRepository): Response
    {
        // Retrieve all testimonials, ordered by newest first.
        $testimonials = $testimonialRepository->findBy([], ['createdAt' => 'DESC']);

        // Render the template with the testimonials data.
        return $this->render('about/index.html.twig', [
            'controller_name' => 'AboutController',
            'testimonials' => $testimonials,
        ]);
    }
}
