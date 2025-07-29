<?php 

namespace App\DataFixtures;

use App\Entity\ProjectType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Fixture to load predefined project types into the database.
 * 
 * This fixture creates a set of project types with their corresponding slugs.
 */
class ProjectTypeFixtures extends Fixture
{
    /**
     * @param SluggerInterface $slugger Service used to generate URL-friendly slugs from type names.
     */
    public function __construct(private SluggerInterface $slugger) {}

    /**
     * Loads project types fixtures into the database.
     *
     * @param ObjectManager $manager The entity manager used to persist data.
     */
    public function load(ObjectManager $manager): void
    {
        // List of predefined project type names
        $types = ['Moteur', 'Entretien', 'Diagnostic', 'Frein', 'Pneumatique', 'Carrosserie'];

        foreach ($types as $name) {
            $type = new ProjectType();
            $type->setName($name);
            // Generate slug from the name and convert it to lowercase
            $type->setSlug(strtolower($this->slugger->slug($name)));

            $manager->persist($type);
        }

        // Persist all created project types to the database
        $manager->flush();
    }
}
