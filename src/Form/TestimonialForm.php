<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Testimonial;
use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

/**
 * Class TestimonialForm
 * 
 * Defines the form for submitting and managing testimonials.
 * Includes fields for author info, message content, approval status,
 * linked user, and Google reCAPTCHA v3 validation.
 */
class TestimonialForm extends AbstractType
{
    /**
     * Builds the testimonial form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array $options Options array for customizing form behavior
     * 
     * Adds form fields corresponding to Testimonial entity properties,
     * including a reCAPTCHA field for spam protection.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', null, [
                'label' => 'Nom',
            ])
            ->add('firstName', null, [
                'label' => 'Prénom',
            ])
            ->add('subject', null, [
                'label' => 'Sujet',
            ])
            ->add('content', null, [
                'label' => 'Message',
            ])
            ->add('createdAt', null, [
                'label' => 'Date de création',
                'widget' => 'single_text', // Use a single input text widget for date selection
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id', // Display user by their ID in the dropdown
                'required' => false,
                'label' => 'Utilisateur',
            ])
            ->add('isApproved', CheckboxType::class, [
                'required' => false,
                'label' => 'Approuver le témoignage ?',
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'avis', // Action name used by reCAPTCHA v3 for validation context
            ]);
    }

    /**
     * Configures options for this form.
     *
     * @param OptionsResolver $resolver Resolver for form options
     * 
     * Sets the data_class to bind form data to the Testimonial entity.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Testimonial::class,
        ]);
    }
}
