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

            // Pour la liste (index)
            TextField::new('message', 'Message')
                ->formatValue(function ($value) {
                    $max = 50;
                    return strlen($value) > $max ? substr($value, 0, $max) . '...' : $value;
                })
                ->onlyOnIndex(),

            // Pour new/edit/show
            TextareaField::new('message', 'Message')
                ->hideOnIndex(),

            DateTimeField::new('createdAt', 'Créé le')->onlyOnIndex(),

            AssociationField::new('user', 'Utilisateur')->hideOnIndex(),
        ];
    }
}
