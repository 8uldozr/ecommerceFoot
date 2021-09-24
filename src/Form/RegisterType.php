<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'constraints' => new Length(['min' => 2]),
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom de famille',
                'constraints' => new Length(['min' => 2]),
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class, 
                'invalid_message' => "le mot de passe doit être identique", 
                'label' => 'Mot de passe',
                'required' => true,
                'first_options' => [ 'label' => 'Mot de passe' ], 
                'second_options' => [ 'label' => 'Confirmez votre mot de passe' ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire",
                'attr' => [
                    'class' => 'btnColor'
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
