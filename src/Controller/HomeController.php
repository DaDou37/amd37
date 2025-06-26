<?php

namespace App\Controller;

use App\Repository\GalleryRepository;
use App\Repository\ProjectRepository;
use App\Repository\ServiceRepository;
use App\Repository\TestimonialRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        ProjectRepository $projectRepo,
        TestimonialRepository $testimonialRepository,
        ServiceRepository $serviceRepo,
        GalleryRepository $galleryRepo
    ): Response
    {
        $projects = $projectRepo->findBy(['isOnline' => true], ['updatedAt' => 'DESC'], 3);
        $testimonials = $testimonialRepository->findBy([], ['createdAt' => 'DESC']);
        $services = $serviceRepo->findBy([], ['position' => 'ASC']);
        $photos = $galleryRepo->findBy([], ['id' => 'DESC'], 6); // Par exemple les 6 dernières photos

        return $this->render('home/index.html.twig', [
            'projects' => $projects,
            'testimonials' => $testimonials,
            'services' => $services,
            'photos' => $photos,
        ]);
    }
}
