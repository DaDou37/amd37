<?php 

// src/DataFixtures/ProjectTypeFixtures.php

namespace App\DataFixtures;

use App\Entity\ProjectType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProjectTypeFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger) {}

    public function load(ObjectManager $manager): void
    {
        $types = ['Moteur', 'Entretien', 'Diagnostic', 'Frein', 'Pneumatique', 'Carrosserie'];

        foreach ($types as $name) {
            $type = new ProjectType();
            $type->setName($name);
            $type->setSlug(strtolower($this->slugger->slug($name)));
            $manager->persist($type);
        }

        $manager->flush();
    }
}
