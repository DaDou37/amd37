<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Fixture to load services into the database.
 *
 * Each service will be created with details such as title, description, slug, position, and an icon filename.
 */
class ServiceFixtures extends Fixture
{
    private SluggerInterface $slugger;

    /**
     * @param SluggerInterface $slugger Service used to generate URL-friendly slugs from service titles.
     */
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    /**
     * Loads services into the database.
     *
     * @param ObjectManager $manager The entity manager used for persistence.
     */
    public function load(ObjectManager $manager): void
    {
        // List of services (title and description)
        $servicesData = [
            ['Changement de pneus', 'Remplacement rapide de pneus usés ou crevés.'],
            ['Équilibrage des roues', 'Pour éviter vibrations et usure irrégulière.'],
            ['Réparation moteur', 'Intervention sur moteurs diesel ou essence.'],
            ['Diagnostic moteur', 'Analyse électronique des pannes moteur.'],
            ['Réglage frein', 'Optimisation du système de freinage.'],
            ['Changement plaquettes', 'Remplacement des plaquettes de frein usées.'],
            ['Vidange moteur', 'Huile remplacée pour préserver le moteur.'],
            ['Remplacement de courroie', 'Changement de la courroie de distribution.'],
            ['Pré-contrôle technique', 'Vérification avant présentation au contrôle.'],
            ['Diagnostic électronique', 'Recherche de pannes via valise OBD.'],
            ['Hydrolique', 'Réflexion de verrin hydrolique'],
            ['Réparation sur godet', 'Réflexion de godet'],
        ];

        // Mapping of service titles to their corresponding icon filenames
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
            'Hydrolique' => 'service_icon_1_12.svg',
            'Réparation sur godet' => 'service_icon_1_12.svg',
        ];

        $position = 1;

        // Create and persist each service entity
        foreach ($servicesData as [$title, $description]) {
            $service = new Service();
            $service->setTitle($title);
            $service->setDescription($description);
            $service->setSlug(strtolower($this->slugger->slug($title)));
            $service->setPosition($position++);
            $service->setCreatedAt(new \DateTimeImmutable());
            $service->setIconFilename($iconMapping[$title] ?? 'default.svg');
            $manager->persist($service);
        }

        // Flush all persisted services to the database
        $manager->flush();
    }
}
