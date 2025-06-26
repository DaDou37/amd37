<?php

namespace App\Controller;

use App\Repository\TestimonialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AboutController extends AbstractController
{
    #[Route('/a-propos', name: 'app_about')]
    public function index(TestimonialRepository $testimonialRepository): Response
    {
        // Récupère tous les témoignages (tu peux filtrer ou limiter si besoin)
        $testimonials = $testimonialRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('about/index.html.twig', [
            'controller_name' => 'AboutController',
            'testimonials' => $testimonials, // <-- tu passes ici la variable attendue
        ]);
    }
}
