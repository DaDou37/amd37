<?php

namespace App\DataFixtures;

use App\Entity\Service;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ServiceFixtures extends Fixture
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        // --- Catégories avec leurs services ---
        $categoriesData = [
            'Pneumatique' => [
                ['Changement de pneus', 'Remplacement rapide de pneus usés ou crevés.'],
                ['Équilibrage des roues', 'Pour éviter vibrations et usure irrégulière.'],
            ],
            'Moteur' => [
                ['Réparation moteur', 'Intervention sur moteurs diesel ou essence.'],
                ['Diagnostic moteur', 'Analyse électronique des pannes moteur.'],
            ],
            'Frein' => [
                ['Réglage frein', 'Optimisation du système de freinage.'],
                ['Changement plaquettes', 'Remplacement des plaquettes de frein usées.'],
            ],
            'Entretien' => [
                ['Vidange moteur', 'Huile remplacée pour préserver le moteur.'],
                ['Remplacement de courroie', 'Changement de la courroie de distribution.'],
                ['Pré-contrôle technique', 'Vérification avant présentation au contrôle.'],
                ['Diagnostic électronique', 'Recherche de pannes via valise OBD.'],
                ['Hydrolique', 'Réflexion de verrin hydrolique'],
                ['Réparation sur godet', 'Réflexion de godet'],
            ],
        ];

        $iconMapping = [
            'Changement de pneus' => 'service_icon_1_3.svg',
            'Équilibrage des roues' => 'service_icon_1_13.svg',
            'Réparation moteur' => 'service_icon_1_12.svg',
            'Diagnostic moteur' => 'service_icon_1_12.svg',
            'Réglage frein' => 'service_icon_1_2.svg',
            'Changement plaquettes' => 'service_icon_1_2.svg',
            'Vidange moteur' => 'service_icon_1_1.svg',
            'Remplacement de courroie' => 'service_icon_1_1.svg',
            'Pré-contrôle technique' => 'service_icon_1_11.svg',
            'Diagnostic électronique' => 'service_icon_1_4.svg',
        ];

        $position = 1;

        foreach ($categoriesData as $categoryName => $services) {
            $category = new Category();
            $category->setName($categoryName);
            $category->setSlug(strtolower($this->slugger->slug($categoryName)));
            $category->setIsOnline(true);
            $category->setUpdatedAt(new \DateTimeImmutable());
            $category->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($category);

            foreach ($services as [$title, $desc]) {
                $service = new Service();
                $service->setTitle($title);
                $service->setDescription($desc);
                $service->setSlug(strtolower($this->slugger->slug($title)));
                $service->setPosition($position++);
                $service->setCreatedAt(new \DateTimeImmutable());
                $service->setCategory($category);
                $service->setIconFilename($iconMapping[$title] ?? 'default.svg');
                $manager->persist($service);
            }
        }

        $manager->flush();
    }
}
