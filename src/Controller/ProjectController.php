<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectForm;
use App\Repository\ProjectRepository;
use App\Repository\ProjectCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/project')]
final class ProjectController extends AbstractController
{
    /**
     * Displays all project categories.
     *
     * @param ProjectCategoryRepository $categoryRepository Repository to fetch all categories.
     *
     * @return Response Rendered project category list view.
     */
    #[Route(name: 'app_project_index', methods: ['GET'])]
    public function index(ProjectCategoryRepository $categoryRepository): Response
    {
        // Retrieve all categories (for filtering or listing)
        $categories = $categoryRepository->findAll();

        return $this->render('project/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * Displays all projects under a specific category.
     *
     * @param string $slug The slug of the category.
     * @param ProjectCategoryRepository $categoryRepository Repository to fetch category data.
     *
     * @return Response Rendered project list for the selected category.
     */
    #[Route('/category/{slug}', name: 'app_project_by_category', methods: ['GET'])]
    public function byCategory(string $slug, ProjectCategoryRepository $categoryRepository): Response
    {
        // Find the category by slug
        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        // If not found, throw a 404 exception
        if (!$category) {
            throw $this->createNotFoundException("Catégorie non trouvée.");
        }

        return $this->render('project/by_category.html.twig', [
            'category' => $category,
            'projects' => $category->getProjects(), // Get all related projects
        ]);
    } 

    /**
     * Displays the details of a single project.
     *
     * @param Project $project The project entity (fetched by slug via ParamConverter).
     *
     * @return Response Rendered project detail page.
     */
    #[Route('/{slug}', name: 'app_project_show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }
}
