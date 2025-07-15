<?php

namespace App\Form;

use App\Entity\Testimonial;
use Symfony\Component\Form\AbstractType;

use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class TestimonialPublicFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Entrez votre nom'],
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'label' => 'Email',
                'attr' => ['placeholder' => 'Entrez votre mail'],
            ])
            ->add('subject', ChoiceType::class, [
                'label' => 'Services',
                'required' => false,
                'placeholder' => 'Sélectionner votre service',
                'choices' => [
                    'Diagnostic Électronique' => 'Diagnostic Électronique',
                    'Carrosserie' => 'Carrosserie',
                    'Diagnostic & Réparation' => 'Diagnostic & Réparation',
                    'Frein & Pneumatique' => 'Frein & Pneumatique',
                    'Entretien' => 'Entretien',
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['placeholder' => 'Votre message', 'rows' => 3],
            ])
            ->add('captcha', Recaptcha3Type::class,[
                'constraints' => new Recaptcha3(),
                'action_name' => 'avis'
            ]);
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Testimonial::class,
        ]);
    }
}
