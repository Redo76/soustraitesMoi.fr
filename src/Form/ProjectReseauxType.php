<?php

namespace App\Form;

use App\Entity\ProjectReseaux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProjectReseauxType extends AbstractType
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
            ->add('activity', TextType::class, [
                'label' => 'Activité :',
                'label_attr' => ['class' => "form-label"],
                'attr' => ['maxlength' => 75],
                'required' => false,
            ])
            ->add('budget', TextType::class, [
                'label' => 'Budget :',
                'label_attr' => ['class' => "form-label"],
                'attr' => ['maxlength' => 50],
                'required' => true,
            ])
            ->add('start_date', DateType::class, [
                'label' => 'Délai de réalisation (date butoir) :',
                'label_attr' => ['class' => "form-label"],
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('mission_duration', TextType::class, [
                'label' => 'Durée de la mission :',
                'label_attr' => ['class' => "form-label"],
                'attr' => ['maxlength' => 50],
                'required' => true,
            ])
            ->add('publication', TextType::class, [
                'label' => 'Combien de publication par jour,
                semaine, ou mois :',
                'label_attr' => ['class' => "form-label"],
                'attr' => ['maxlength' => 50],
                'required' => true,
            ])
            ->add('website', TextType::class, [
                'label' => 'Site internet :',
                'label_attr' => ['class' => "form-label"],
                'attr' => ['maxlength' => 255],
                'required' => true,
            ])
            ->add('location', TextType::class, [
                'label' => 'Dates et lieux (si événement, …) :',
                'label_attr' => ['class' => "form-label"],
                'attr' => ['maxlength' => 200],
                'required' => false,
            ])
            ->add('logo', FileType::class, [
                'label' => 'Logo (à insérer) :',
                'label_attr' => ['class' => "form-label"],
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
            ->add('snapchat', TextType::class, [
                'label' => 'Snapchat :',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 255],
                'required' => false,
            ])
            ->add('tiktok', TextType::class, [
                'label' => 'TikTok :',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 255],
                'required' => false,
            ])
            ->add('instagram', TextType::class, [
                'label' => 'Instagram :',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 255],
                'required' => false,
            ])
            ->add('facebook', TextType::class, [
                'label' => 'Facebook :',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 255],
                'required' => false,
            ])
            ->add('linkedin', TextType::class, [
                'label' => 'LinkedIn :',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 255],
                'required' => false,
            ])
            ->add('twitter', TextType::class, [
                'label' => 'Twitter :',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 255],
                'required' => false,
            ])
            ->add('pinterest', TextType::class, [
                'label' => 'Pinterest :',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 255],
                'required' => false,
            ])
            ->add('other_media', TextType::class, [
                'label' => 'Autres :',
                'label_attr' => ['class' => "form-label-misc"],
                'attr' => ['maxlength' => 255],
                'required' => false,
            ])
            ->add('community_manager', TextType::class, [
                'label' => 'Parmi ceux-ci quelles sont ceux sur lesquels vous souhaitez faire appel à un Community
                Manager ?',
                'label_attr' => ['class' => "form-label"],
                'attr' => ['maxlength' => 200],
                'required' => false,
            ])
            ->add('impact', TextareaType::class, [
                'label' => 'Ce que vous souhaitez transmettre comme informations au public via votre communication
                (tarif produits, etc) ? Quel est l’objectif poursuivit ?',
                'label_attr' => ['class' => "form-label-misc"],
            ])
            ->add('desired_colors', TextType::class, [
                'label' => 'Couleurs souhaitées sur votre communication (en général en lien avec le logo) ? et pourquoi celles-ci :',
                'label_attr' => ['class' => "form-label"],
                'attr' => ['maxlength' => 255],
                'required' => false,
            ])
            ->add('liked_example', TextAreaType::class, [
                'label' => 'Montrer des exemples de pages que vous avez consulté que vous aimez (Et pourquoi ?
                dans la mise en page, les couleurs, les visuels, etc)',
                'label_attr' => ['class' => "form-label-misc"],
                'required' => false,
            ])
            ->add('example', FileType::class, [
                'label' => 'false',
                'label_attr' => ['class' => "form-label-misc hide"],
                "multiple" => true,
                "required" => false,
                "mapped" => false,
                'attr' => ['class' => "fileInput", 'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'right', 'title' => 'Afin de sélectionner plusieurs images, maintenez Ctrl+clic de la souris.'],
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjectReseaux::class,
        ]);
    }
}
