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

class TestimonialForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', null, ['label' => 'Nom'])
            ->add('email', null, ['label' => 'Email'])
            ->add('subject', null, ['label' => 'Sujet'])
            ->add('content', null, ['label' => 'Message'])
            ->add('createdAt', null, ['label' => 'Date de création', 'widget' => 'single_text'])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
                'required' => false,
                'label' => 'Utilisateur',
            ])
            ->add('isApproved', CheckboxType::class, [
                'required' => false,
                'label' => 'Approuver le témoignage ?',
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
