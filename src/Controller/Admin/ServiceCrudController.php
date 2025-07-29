<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),

            TextField::new('title', 'Titre'),
            TextareaField::new('description', 'Description')->hideOnIndex(),

            SlugField::new('slug')->setTargetFieldName('title')->hideOnIndex(),

            IntegerField::new('position', 'Position'),
            DateTimeField::new('createdAt', 'Date de création'),

            // Affichage de l'icône à partir du nom de fichier
            ImageField::new('iconFilename', 'Icône')
                ->setBasePath('/assets/img/icon') // <-- le chemin public
                ->setUploadDir('public/assets/img/icon') // <-- ici on ne s'en sert pas vraiment
                ->setRequired(false)
                ->onlyOnIndex(), // tu peux aussi mettre `.onlyOnDetail()` si besoin

            
            
        ];
    }
}
