<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Donnez un nom à votre adresse'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom de famille'
            ])
            ->add('company', TextType::class, [
                'label' => '(facultatif) Nom de votre société',
                'required' => false,
            ])
            ->add('address', TextType::class, [
                'label' => 'Nom et numéro de rue'
            ])
            ->add('zip', TextType::class, [
                'label' => 'Code postal/Zip'
            ])
            ->add('city', TextType::class, [
                'label' => 'ville'
            ])
            ->add('country', CountryType::class, [
                'label' => 'Votre pays'
            ])
            ->add('phone', TelType::class, [
                'label' => ' Numéro de téléphone'
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Valider'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
