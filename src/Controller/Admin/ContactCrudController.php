<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),

            TextField::new('firstName', 'Prénom'),
            TextField::new('lastName', 'Nom'),
            EmailField::new('email', 'Email'),

            TextField::new('subject', 'Sujet'),
                    TextField::new('message', 'Message')
            ->formatValue(function ($value, $entity) {
                
                $max = 50;
                if (strlen($value) > $max) {
                    return substr($value, 0, $max) . '...';
                }
                return $value;
            })
            ->onlyOnIndex(),


            DateTimeField::new('createdAt', 'Créé le')->onlyOnIndex(),

            AssociationField::new('user', 'Utilisateur')->hideOnIndex(),
        ];
    }
}
