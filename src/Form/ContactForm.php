<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

/**
 * Class ContactForm
 * 
 * Defines the form structure for the Contact entity.
 * Includes fields for user contact details, message, and Google reCAPTCHA v3 verification.
 */
class ContactForm extends AbstractType
{
    /**
     * Build the contact form.
     * 
     * @param FormBuilderInterface $builder The form builder object
     * @param array $options Options passed when creating the form
     * 
     * This method adds fields for first name, last name, email, subject, message,
     * and reCAPTCHA verification. Additionally, it can optionally include a User entity
     * selection if the 'include_user' option is set to true.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Entrez votre prénom']
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Entrez votre nom']
            ])
            ->add('email', TextType::class, [
                'label' => 'Adresse e-mail',
                'attr' => ['placeholder' => 'Entrez votre e-mail']
            ])
            ->add('subject', ChoiceType::class, [
                'label' => 'Sujet',
                'choices' => [
                    'Diagnostic Électronique' => 'Diagnostic Electronique',
                    'Carrosserie' => 'Carrosserie',
                    'Diagnostic & Réparation moteur' => 'Diagnostic & Reparation moteur',
                    'Frein & Pneumatique' => 'Frein & Pneumatique',
                    'Entretien' => 'Entretien',
                ],
                'placeholder' => 'Sélectionner votre service',
                'attr' => ['class' => 'form-select style-white2']
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => [
                    'placeholder' => 'Écrivez votre message ici',
                    'rows' => 5
                ]
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'contact' // Defines the action name used for reCAPTCHA verification
            ]);

        // Optionally include a user selection field if 'include_user' option is true
        if ($options['include_user']) {
            $builder->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email', // Display user's email as the choice label
            ]);
        }
    }

    /**
     * Configure form options.
     * 
     * @param OptionsResolver $resolver The resolver for the options
     * 
     * Sets the data class bound to this form (Contact entity) and
     * adds a custom option 'include_user' to optionally add the user field.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'include_user' => false, // Default: do not include the user field
        ]);
    }
}
