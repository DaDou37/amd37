<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\ProjectTypeRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\ProjectCategoryRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private SluggerInterface $slugger,
        private UserRepository $userRepository,
        private ProjectCategoryRepository $categoryRepository,
        private ProjectTypeRepository $typeRepository,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $user = $this->userRepository->findOneBy([]);
        if (!$user) {
            throw new \Exception('Aucun utilisateur en base.');
        }

        $projectsData = [
            //  POIDS LOURD
            [
                'title' => 'Frein et roulement sur poids lourd',
                'description' => 'Remplacement des disques et roulements sur essieu arrière.',
                'picture' => 'poids-lourd_disque-frein_2016.jpg',
                'categorySlug' => 'poids-lourd',
                'typeSlug' => 'frein',
            ],
            [
                'title' => 'Réparation moyeu Poids Lourd',
                'description' => 'Intervention complète sur le moyeu.',
                'picture' => 'poids-lourd_moyeu_2016.jpg',
                'categorySlug' => 'poids-lourd',
                'typeSlug' => 'frein',
            ],
            [
                'title' => 'Réglage de porte charnière 1',
                'description' => 'Remise en état des charnières arrière sur camion.',
                'picture' => 'poids-lourd_porte-charniere1_2016.jpg',
                'categorySlug' => 'poids-lourd',
                'typeSlug' => 'carrosserie',
            ],
            [
                'title' => 'Réglage de porte charnière 2',
                'description' => 'Remise en état des charnières arrière sur camion.',
                'picture' => 'poids-lourd_porte-charniere2_2016.jpg',
                'categorySlug' => 'poids-lourd',
                'typeSlug' => 'carrosserie',
            ],

            //  VÉHICULE LÉGER
            [
                'title' => 'Boîte de vitesse',
                'description' => 'Changement de boîte de vitesse.',
                'picture' => 'vehicule_boite_2025.jpg',
                'categorySlug' => 'vehicule-leger',
                'typeSlug' => 'moteur',
            ],
            [
                'title' => 'Arbre à cames',
                'description' => 'Changement de l’arbre à cames.',
                'picture' => 'vehicule_arbre_2025.jpg',
                'categorySlug' => 'vehicule-leger',
                'typeSlug' => 'moteur',
            ],
            [
                'title' => 'Culasse',
                'description' => 'Changement de culasse.',
                'picture' => 'vehicule_culasse_2025.jpg',
                'categorySlug' => 'vehicule-leger',
                'typeSlug' => 'moteur',
            ],
        ];

        //  Projets ENGIN DE CHANTIER
        $projectsData = array_merge($projectsData, $this->generateSeries(
            'Hydraulique et système électrique sur grue',
            'Réparation hydraulique sur grue & système électrique.',
            'Engin-chantier_hydrolique',
            9,
            'engin-de-chantier',
            'entretien'
        ));

        $projectsData[] = [
            'title' => 'Chenilles sur mini-pelle',
            'description' => 'Réparation et changement de chenilles.',
            'picture' => 'Engin-chantier_pneumatique_2025.jpg',
            'categorySlug' => 'engin-de-chantier',
            'typeSlug' => 'pneumatique',
        ];

        //  Projets LOCOMOTIVE
        $projectsData = array_merge($projectsData, $this->generateSeries(
            'Réparation de châssis locomotive',
            'Travaux sur le châssis d’une locomotive.',
            'Locomotive_chassis',
            5,
            'locomotive',
            'carrosserie'
        ));

        $projectsData = array_merge($projectsData, $this->generateSeries(
            'Réparation moteur locomotive',
            'Entretien et remise en état du moteur locomotive.',
            'Locomotive_moteur',
            4,
            'locomotive',
            'moteur'
        ));

        //  Création des entités
        foreach ($projectsData as $index => $data) {
            $category = $this->categoryRepository->findOneBy(['slug' => $data['categorySlug']]);
            $type = $this->typeRepository->findOneBy(['slug' => $data['typeSlug']]);

            if (!$category || !$type) {
                throw new \Exception("Catégorie '{$data['categorySlug']}' ou type '{$data['typeSlug']}' introuvable.");
            }

            $project = new Project();
            $project->setTitle($data['title']);
            $project->setSlug(strtolower($this->slugger->slug($data['title'] . '-' . ($index + 1))));
            $project->setDescription($data['description']);
            $project->setPicture($data['picture']);
            $project->setCreatedAt(new \DateTimeImmutable());
            $project->setUpdatedAt(new \DateTimeImmutable());
            $project->setIsOnline(true);
            $project->setUser($user);
            $project->setProjectCategory($category);
            $project->setType($type);

            $manager->persist($project);
        }

        $manager->flush();
    }

    private function generateSeries(string $title, string $description, string $filenamePrefix, int $count, string $categorySlug, string $typeSlug): array
    {
        $entries = [];
        for ($i = 1; $i <= $count; $i++) {
            $entries[] = [
                'title' => "$title #$i",
                'description' => $description,
                'picture' => sprintf('%s%d_2025.jpg', $filenamePrefix, $i),
                'categorySlug' => $categorySlug,
                'typeSlug' => $typeSlug,
            ];
        }
        return $entries;
    }

    public function getDependencies(): array
    {
        return [
            ProjectCategoryFixtures::class,
            ProjectTypeFixtures::class,
        ];
    }
}
