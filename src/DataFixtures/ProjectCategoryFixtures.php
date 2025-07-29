<?php

namespace App\DataFixtures;

use App\Entity\ProjectCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Loads default project categories into the database.
 * This fixture is useful to populate the application with predefined categories for projects.
 */
class ProjectCategoryFixtures extends Fixture
{
    /**
     * Seeds the database with default project categories.
     *
     * @param ObjectManager $manager The Doctrine object manager.
     */
    public function load(ObjectManager $manager): void
    {
        // Predefined category data to be inserted
        $categories = [
            [
                'name' => 'Véhicule Léger',
                'slug' => 'vehicule-leger',
                'image' => 'assets/img/service/2cv.jpg'
            ],
            [
                'name' => 'Engin de Chantier',
                'slug' => 'engin-de-chantier',
                'image' => 'assets/img/service/mini-pelle.jpg'
            ],
            [
                'name' => 'Poids Lourd',
                'slug' => 'poids-lourd',
                'image' => 'assets/img/service/pl.jpg'
            ],
            [
                'name' => 'Locomotive',
                'slug' => 'locomotive',
                'image' => 'assets/img/service/locomotive.jpg'
            ],
        ];

        // Create and persist each ProjectCategory entity
        foreach ($categories as $catData) {
            $category = new ProjectCategory();
            $category->setName($catData['name']);
            $category->setSlug($catData['slug']);
            $category->setImage($catData['image']);
            $category->setDescription('Voici une rubrique photo montrant mes projets sur : ' . $catData['name']);

            $manager->persist($category);
        }

        // Finalize and flush to database
        $manager->flush();
    }
}
