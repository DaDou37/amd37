<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectForm;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProjectCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/project')]
final class ProjectController extends AbstractController
{
    #[Route(name: 'app_project_index', methods: ['GET'])]
    public function index(ProjectCategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('project/index.html.twig', [
            'categories' => $categories,
        ]);
    }


    #[Route('/category/{slug}', name: 'app_project_by_category', methods: ['GET'])]
    public function byCategory(string $slug, ProjectCategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        if (!$category) {
            throw $this->createNotFoundException("Catégorie non trouvée.");
        }

        return $this->render('project/by_category.html.twig', [
            'category' => $category,
            'projects' => $category->getProjects(),
        ]);
    }
}
