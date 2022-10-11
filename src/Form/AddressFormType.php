<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address',TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Adresse'],
            ])
            ->add('address2',TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Adresse ligne 2'],
            ])
            ->add('codePostal',TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Code Postal'],
            ])
            ->add('city',TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Ville'],
            ])
            ->add('country',TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Pays'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
