<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class EditProfileClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('avatar', FileType::class, [
            "label" => false,
            "required" => false,
            'row_attr' => ['class' => 'mb-0 ms-2 avatar'],
            'mapped' => false,
            'constraints' => [
                new Image([
                    'maxSize' => '5M'
                ])
            ]
        ])
        ->add('firstname', TextType::class, [
            'label' => false,
            'attr' => ['class' => 'firstName','placeholder' => 'Prénom'],
            'required' => true,
        ])
        ->add('lastname', TextType::class, [
            'label' => false,
            'attr' => ['class' => 'Nom','placeholder' => 'Nom'],
            'required' => true,
        ])
        ->add('email', EmailType::class, [
            'label' => false,
            'attr' => ['placeholder' => 'Email'],
            'required' => true,
        ])
        ->add('phone', TelType::class,[
            'label' => false,
            'attr' => ['placeholder' => 'N° Téléphone'],
            "required" => false,
            'constraints' => [
                new Regex([
                    'pattern'=> '/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/',
                    'match'=> true,
                    'message'=> 'Entrez un numéro valide',
                ]),
            ]
        ])
        ->add('address', AddressFormType::class)
        ->add('isCompany', ChoiceType::class, [
            "label" => false,
            'attr' => ['class' => 'isCompanyInput'],
            'required' => true,
            "expanded" => true,
            "multiple" => false,
            'choices' => [
                'Vous êtes particulier' => false,
                "Vous êtes professionnel" => true,
            ],
            'choice_attr' => [
                'Vous êtes particulier' => ['class' => 'InputParticulier'],
                'Vous êtes professionnel' => ['class' => 'InputCompany'],
            ],
        ])
        ->add('companyName', TextType::class, [
            'label' => false,
            'attr' => ['placeholder' => 'Nom'],
            "required" => false,
        ])
        ->add('companyCommercialName', TextType::class, [
            'label' => false,
            'attr' => ['placeholder' => 'Nom comercial'],
            "required" => false,
        ])
        ->add('jobInCompany', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['placeholder' => "Fonction dans l'entreprise"],
        ])
        ->add('siret', TextType::class, [
            'label' => false,
            'attr' => ['placeholder' => 'N° de siret'],
            "required" => false,
            'constraints' => [
                new Regex([
                    'pattern'=> '/^[0-9]{14}$/',
                    'match'=> true,
                    'message'=> 'Veuillez entrer un numéro valide',
                ]),
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
