<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\String\Slugger\AsciiSlugger;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class ProjectCrudController extends AbstractCrudController
{
   

    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextareaField::new('description', 'Description'),
            AssociationField::new('projectCategory', 'Catégorie'),
            AssociationField::new('type', 'Type de projet'), 
            ImageField::new('picture', 'Image')
                ->setBasePath('/assets/img/projects')
                ->setUploadDir('public/assets/img/projects')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->setRequired(false),
            BooleanField::new('isOnline', 'En ligne'),
            // Optionnel : masquer le champ "user" si tu préfères l'assigner automatiquement
            // AssociationField::new('user', 'Auteur'),
        ];
    }

public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
{
    if (!$entityInstance instanceof Project) return;

    // Slug automatique
    $slugger = new AsciiSlugger();
    $entityInstance->setSlug(strtolower($slugger->slug($entityInstance->getTitle())));

    // Date de création si pas déjà mise
    if (!$entityInstance->getCreatedAt()) {
        $entityInstance->setCreatedAt(new \DateTimeImmutable());
    }

    // Récupérer l'admin (par exemple ici par email)
    if (!$entityInstance->getUser()) {
        $admin = $entityManager->getRepository(User::class)->findOneBy(['email' => 'admin@amd37.com']);
        $entityInstance->setUser($admin);
    }

    parent::persistEntity($entityManager, $entityInstance);
}


}
