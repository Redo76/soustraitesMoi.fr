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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => false, 'attr' => ['placeholder' => 'Mot de passe']],
                'second_options' => ['label' => false, 'attr' => ['placeholder' => 'Confirmation mot de passe']],
                'constraints' => [
                    new Regex([
                        'pattern'=> '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,}$/',
                        'match'=> true,
                        'message'=> 'Veuillez entrer un mot de passe contenant 6 caractères dont 1 majusucle, 1 minuscule et 1 chiffre',
                    ]),
                ]
            ])
            ->add('phone', TelType::class,[
                'label' => false,
                'attr' => ['placeholder' => 'N° Téléphone'],
                'constraints' => [
                    new Regex([
                        'pattern'=> '/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/',
                        'match'=> true,
                        'message'=> 'Entrez un numéro valide',
                    ]),
                ]
            ])
            ->add('address', AddressFormType::class,[
                "label" => false,
            ])
            ->add('isCompany', ChoiceType::class, [
                "label" => false,
                'required' => true,
                "expanded" => true,
                "multiple" => false,
                'choices' => [
                    'Vous êtes particulier' => false,
                    "Vous êtes professionnel" => true,
                ],
                'data' => false
            ])
            ->add('companyName', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Nom'],
            ])
            ->add('companyCommercialName', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Nom comercial'],
            ])
            
            ->add('siret', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'N° de siret'],
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
