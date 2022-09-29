<?php

namespace App\Form;

use App\Entity\User;
use App\Form\AddressFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationExpertFormType extends AbstractType
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
                'required' => true,
                'options' => ['attr' => ['class' => 'password-field']],
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation de mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Un mot de passe est requis.',
                    ]),
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
            ->add('address', AddressFormType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
