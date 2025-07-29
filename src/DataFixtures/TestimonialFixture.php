<?php

namespace App\DataFixtures;

use App\Entity\Testimonial;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Fixture class to populate the database with sample testimonial data.
 * 
 * This fixture uses the Faker library to generate random names and content for testimonials.
 */
class TestimonialFixture extends Fixture
{
    /**
     * Loads and persists testimonial entities into the database.
     *
     * @param ObjectManager $manager The Doctrine object manager.
     */
    public function load(ObjectManager $manager): void
    {
        // Create a Faker generator instance with French localization
        $faker = Factory::create('fr_FR');

        // Generate 10 fake testimonials
        for ($i = 0; $i < 10; $i++) {
            $testimonial = new Testimonial();
            $testimonial->setAuthor($faker->name());
            $testimonial->setContent($faker->paragraph());

            // Set the creation date to a random time within the past 6 months
            $testimonial->setCreatedAt(
                new \DateTimeImmutable(
                    $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d H:i:s')
                )
            );

            $manager->persist($testimonial);
        }

        // Persist all testimonials to the database
        $manager->flush();
    }
}
