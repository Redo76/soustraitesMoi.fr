<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom_du_projet', TextType::class, [
                'label' => 'Nom du projet',
                'label_attr' => ['class' => "form-label"],
                'attr' => ['maxlength' => 75],
                'required' => false,
            ])
            ->add('Categorie', TextType::class,[
                'attr' => ['maxlength' => 75],
            ])
            ->add('Description', TextareaType::class, [
                'label' => 'Description',
                'label_attr' => ['class' => "form-label"],
            ])
            ->add('Images', FileType::class, [
                "multiple" => true,
                "required" => false,
                "mapped" => false,
                'row_attr' => ['class' => 'project_imgs'],
                'attr' => ['class' => 'fileInput', 'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'right', 'title' => 'Afin de sélectionner plusieurs images, maintenez Ctrl+clic de la souris.'],
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
            // ->add('Statut')
            // ->add('User')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
