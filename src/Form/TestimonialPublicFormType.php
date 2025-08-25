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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

/**
 * Class TestimonialPublicFormType
 * 
 * Defines a public-facing testimonial submission form.
 * It collects user name, optional email, service subject, message content,
 * and includes Google reCAPTCHA v3 for spam prevention.
 */
class TestimonialPublicFormType extends AbstractType
{
    /**
     * Builds the public testimonial submission form.
     *
     * @param FormBuilderInterface $builder Form builder interface to add fields
     * @param array $options Options array to customize form behavior
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Entrez votre nom'],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Entrez votre prénom'],
                'required' => true,
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
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'avis', // Context for reCAPTCHA v3 verification
            ]);
    }

    /**
     * Configures the options for this form.
     *
     * @param OptionsResolver $resolver Resolver for form options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        // Bind this form to the Testimonial entity
        $resolver->setDefaults([
            'data_class' => Testimonial::class,
        ]);
    }
}
