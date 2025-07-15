<?php

namespace App\DataFixtures;

use App\Entity\Testimonial;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TestimonialFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $testimonial = new Testimonial();
            $testimonial->setAuthor($faker->name());
            $testimonial->setContent($faker->paragraph());
            
            $testimonial->setCreatedAt(new \DateTimeImmutable($faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d H:i:s')));

            $manager->persist($testimonial);
        }

        $manager->flush();
    }
}
