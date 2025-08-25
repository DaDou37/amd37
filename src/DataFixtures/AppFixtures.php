<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * AppFixtures is used to preload the database with default data for development or testing purposes.
 */
class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    /**
     * Injects the password hasher to securely encode user passwords.
     *
     * @param UserPasswordHasherInterface $hasher The password hasher service.
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * This method is called automatically when running `php bin/console doctrine:fixtures:load`.
     * It creates an admin user with predefined credentials.
     *
     * @param ObjectManager $manager The Doctrine object manager.
     */
    public function load(ObjectManager $manager): void
    {
        // Create an admin user
        $admin = new User();
        $admin->setFirstname('Sylvain');
        $admin->setLastname('Mestivier');
        $admin->setEmail('admin@amd37.com');
        $admin->setRole('ROLE_ADMIN');
        $admin->setCreatedAt(new \DateTimeImmutable());

        // Securely hash the password before storing
        $hashedPassword = $this->hasher->hashPassword($admin, $_ENV['ADMIN_PASSWORD']);
        $admin->setPassword($hashedPassword);

        // Persist the user to the database
        $manager->persist($admin);
        $manager->flush();
    }
}
