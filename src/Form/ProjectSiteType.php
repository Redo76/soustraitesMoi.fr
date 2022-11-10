<?php

namespace App\Form;

use App\Entity\ProjectSite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProjectSiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom_du_projet', TextType::class, [
                'label' => 'Nom du projet :',
                'label_attr' => ['class' => "form-label"],
                'attr' => ['maxlength' => 75],
                'required' => true,
            ])
            ->add('presentation', TextareaType::class, [
                'label' => 'Présentation du projet en quelques lignes :',
                'label_attr' => ['class' => "form-label"],
                "required" => true,
            ])
            ->add('activity', TextType::class, [
                'label' => 'Activité principale :',
                'label_attr' => ['class' => "form-label"],
                'attr' => ['maxlength' => 75],
                'required' => true,
            ])
            ->add('offers', TextType::class, [
                'label' => 'Offres et projets :',
                'label_attr' => ['class' => "form-label"],
                'attr' => ['maxlength' => 150],
                'required' => true,
            ])
            ->add('service', TextType::class, [
                'label' => 'Services (Service client / vente à domicile) :',
                'label_attr' => ['class' => "form-label"],
                'attr' => ['maxlength' => 150],
                'required' => true,
            ])
            ->add('valeurs', TextType::class, [
                'label' => 'Les valeurs (au moins 3) :',
                'label_attr' => ['class' => "form-label"],
                'attr' => ['maxlength' => 150],
                'required' => true,
                ])
            ->add('profil_client', TextareaType::class, [
                'label' => 'Profil client :',
                'label_attr' => ['class' => "form-label"],
                "required" => true,
            ])
            ->add('main_objective', TextareaType::class, [
                'label' => 'Objectif principal :',
                'label_attr' => ['class' => "form-label-misc"],
                "required" => true,
            ])
            ->add('secondary_objective', TextareaType::class, [
                'label' => 'Objectif secondaire :',
                'label_attr' => ['class' => "form-label-misc"],
                "required" => true,
            ])
            ->add('homepage', TextareaType::class, [
                'label' => 'Accueil :',
                'label_attr' => ['class' => "form-label-misc"],
                "required" => true,
            ])
            ->add('about', TextareaType::class, [
                'label' => 'À propos / notre histoire :',
                'label_attr' => ['class' => "form-label-misc"],
                "required" => true,
            ])
            ->add('our_services', TextareaType::class, [
                'label' => 'Nos services :',
                'label_attr' => ['class' => "form-label-misc"],
                "required" => true,
            ])
            ->add('contact', TextareaType::class, [
                'label' => 'Contact :',
                'label_attr' => ['class' => "form-label-misc"],
                "required" => true,
            ])
            ->add('contact_form', TextType::class, [
                'label' => 'Formulaire de contact :',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 50],
                'required' => true,
            ])
            ->add('search_bar', TextType::class, [
                'label' => 'Moteur de recherche sur-mesure :',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 50],
                'required' => true,
            ])
            ->add('catalogue', TextType::class, [
                'label' => 'Catalogue produit :',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 50],
                'required' => true,
            ])
            ->add('client', TextType::class, [
                'label' => 'Espace client :',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 50],
                'required' => true,
                ])
            ->add('newsletter', TextType::class, [
                'label' => 'Inscription newsletter :',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 50],
                'required' => true,
            ])
            ->add('logo', TextType::class, [
                'label' => 'Logo ?',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 150,'placeholder' => "par ex -> non j'en ai déja un"
                ],
                'required' => true,
            ])
            ->add('logo_files', FileType::class, [
                'label' => 'logo',
                'label_attr' => ['class' => "form-label-misc hide"],
                "multiple" => true,
                "required" => false,
                "mapped" => false,
                'attr' => ['class' => "fileInput", 'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'right', 'title' => 'Afin de sélectionner plusieurs images, maintenez Ctrl+clic de la souris.'],
                'row_attr' => ['class' => 'project_imgs mb-3'],
                'constraints' => [
                    new All([
                        'constraints' => [
                            new Image([
                                'maxSize' => '5M'
                            ])
                        ],
                    ]),
                ]
            ])
            ->add('visuals', TextType::class, [
                'label' => 'Visuels ?',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 255,'placeholder' => 'oui/non je fournis (ou pas) les illustrations'],
                'required' => true,
            ])
            ->add('visuals_files', FileType::class, [
                'label' => 'visuel',
                'label_attr' => ['class' => "form-label hide"],
                "multiple" => true,
                "required" => false,
                "mapped" => false,
                'attr' => ['class' => "fileInput",'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'right', 'title' => 'Afin de sélectionner plusieurs images, maintenez Ctrl+clic de la souris.'],
                'row_attr' => ['class' => 'project_imgs2 mb-3'],
                'constraints' => [
                    new All([
                        'constraints' => [
                            new Image([
                                'maxSize' => '5M'
                            ])
                        ],
                    ]),
                ]
            ])
            ->add('typography', TextType::class, [
                'label' => 'Typographie ?',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 50],
                'required' => true,
            ])
            ->add('colors', TextType::class, [
                'label' => 'Couleurs ?',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 50],
                'required' => true,
            ])
            ->add('loved_sites', TextType::class, [
                'label' => 'Sites coup de cœur :',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 255],
                'required' => false,
            ])
            ->add('other_site', TextAreaType::class, [
                'label' => 'Sites concurrents :',
                'label_attr' => ['class' => "form-label-misc"],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjectSite::class,
        ]);
    }
}
