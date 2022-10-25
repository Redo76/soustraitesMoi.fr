<?php

namespace App\Form;

use App\Entity\User;
use App\Form\AddressFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class EditProfileExpertType extends AbstractType
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
            'attr' => ['class' => 'firstName','placeholder' => 'Prénom','maxlength' => 75],
            'required' => true,
        ])
        ->add('lastname', TextType::class, [
            'label' => false,
            'attr' => ['class' => 'Nom','placeholder' => 'Nom','maxlength' => 75],
            'required' => true,
        ])
        ->add('email', EmailType::class, [
            'label' => false,
            'attr' => ['placeholder' => 'Email','maxlength' => 180],
            'required' => true,
        ])
        ->add('phone', TelType::class,[
            'label' => false,
            'attr' => ['placeholder' => 'N° Téléphone','maxlength' => 20],
            'constraints' => [
                new Regex([
                    'pattern'=> '/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/',
                    'match'=> true,
                    'message'=> 'Entrez un numéro valide',
                ]),
            ]
        ])
        ->add('address', AddressFormType::class)
        ->add('companyName', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['placeholder' => 'Nom','maxlength' => 75],
        ])
        ->add('companyCommercialName', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['placeholder' => 'Nom comercial','maxlength' => 180],
        ])
        ->add('jobInCompany', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['placeholder' => "Fonction dans l'entreprise",'maxlength' => 75],
        ])
        ->add('siret', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['placeholder' => 'N° de siret','maxlength' => 14],
            'constraints' => [
                new Regex([
                    'pattern'=> '/^[0-9]{14}$/',
                    'match'=> true,
                    'message'=> 'Veuillez entrer un numéro valide',
                ]),
            ]
        ])
        ->add('cv', FileType::class, [
            "label" => false,
            "required" => false,
            'row_attr' => ['class' => 'mb-0 ms-2 avatar'],
            'mapped' => false,
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
