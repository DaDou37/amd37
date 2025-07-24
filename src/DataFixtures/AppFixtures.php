<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setFirstname('Sylvain');
        $admin->setLastname('Mestivier');
        $admin->setEmail('admin@amd37.com');
        $admin->setRole('ROLE_ADMIN');
        $admin->setCreatedAt(new \DateTimeImmutable());

        $hashedPassword = $this->hasher->hashPassword($admin, 'HugoDavid');
        $admin->setPassword($hashedPassword);

        $manager->persist($admin);
        $manager->flush();
    }
}

