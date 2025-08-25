<?php

namespace App\Controller\Admin;

use App\Entity\Testimonial;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TestimonialCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Testimonial::class;
    }

public function configureFields(string $pageName): iterable
{
    return [
        IdField::new('id')->onlyOnIndex(),
        TextField::new('author'),
        TextField::new('firstName', 'Prénom'),
        TextField::new('subject'),
        TextEditorField::new('content'),
        BooleanField::new('isApproved', 'Approuvé ?'),
        DateTimeField::new('createdAt')->onlyOnIndex(),
    ];
}
}
