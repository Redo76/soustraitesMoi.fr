<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationExpertInfoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('phone', TelType::class,[
            //     'label' => false,
            //     'attr' => ['placeholder' => 'N° Téléphone'],
            //     'constraints' => [
            //         new Regex([
            //             'pattern'=> '/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/',
            //             'match'=> true,
            //             'message'=> 'Entrez un numéro valide',
            //         ]),
            //     ]
            // ])
            ->add('address', AddressFormType::class,[
                "label" => false,
            ])
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
