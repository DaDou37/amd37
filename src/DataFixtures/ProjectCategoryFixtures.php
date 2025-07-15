<?php

namespace App\DataFixtures;

use App\Entity\ProjectCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            ['name' => 'Véhicule Léger', 'slug' => 'vehicule-leger', 'image' => 'assets/img/service/2cv.jpg'],
            ['name' => 'Engin de Chantier', 'slug' => 'engin-de-chantier', 'image' => 'assets/img/service/mini-pelle.jpg'],
            ['name' => 'Poids Lourd', 'slug' => 'poids-lourd', 'image' => 'assets/img/service/pl.jpg'],
        ];

        foreach ($categories as $catData) {
            $category = new ProjectCategory();
            $category->setName($catData['name']);
            $category->setSlug($catData['slug']);
            $category->setImage($catData['image']);
            $category->setDescription('Voici une rubrique photo montrant mes projets sur : ' . $catData['name']);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
