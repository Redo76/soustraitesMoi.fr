<?php

namespace App\Form;

use App\Entity\ProjectLogo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProjectLogoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand_name', TextType::class, [
                'label' => 'Nom de marque :',
                'label_attr' => ['class' => "form-label"],
                'required' => true,
            ])
            ->add('activity', TextType::class, [
                'label' => 'Activité :',
                'label_attr' => ['class' => "form-label"],
                'required' => false,
            ])
            ->add('budget', TextType::class, [
                'label' => 'Budget :',
                'label_attr' => ['class' => "form-label"],
                'required' => true,
            ])
            ->add('start_date', DateType::class, [
                'label' => 'Délai de réalisation (date butoir) :',
                'label_attr' => ['class' => "form-label"],
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('explanation', TextareaType::class, [
                'label' => 'Explication de la marque et des valeurs de la marque :',
                'label_attr' => ['class' => "form-label-misc"],
            ])
            ->add('desired_colors', TextType::class, [
                'label' => 'Couleurs souhaitées et pourquoi :',
                'label_attr' => ['class' => "form-label"],
                'required' => true,
            ])
            ->add('unwanted_colors', TextType::class, [
                'label' => 'Couleurs non souhaitées et pourquoi :',
                'label_attr' => ['class' => "form-label"],
                'required' => true,
            ])
            ->add('good_logo_example', FileType::class, [
                'label' => 'Montrer les exemples de logos (avec des captures écran) que vous aimez :',
                'label_attr' => ['class' => "form-label-misc"],
                "multiple" => true,
                "required" => false,
                "mapped" => false,
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
            ->add('bad_logo_example', FileType::class, [
                'label' => 'Montrer les exemples de logos (avec des captures écran) que vous n’aimez pas :',
                'label_attr' => ['class' => "form-label-misc"],
                "multiple" => true,
                "required" => false,
                "mapped" => false,
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
            ->add('other_brands', TextType::class, [
                'label' => '* C’est une indication supplémentaire',
                'label_attr' => ['class' => "form-label-misc"],
                'required' => true,
            ])
            ->add('support', TextType::class, [
                'label' => 'Quels seront les supports sur lesquels votre logo sera utilisé ?',
                'label_attr' => ['class' => "form-label-misc"],
                'required' => true,
            ])
            ->add('creation', ChoiceType::class, [
                'label' => 'Avez-vous besoin des fichiers de création (Photoshop) ?',
                'label_attr' => ['class' => "form-label-misc"],
                'required' => true,
                "expanded" => true,
                "multiple" => false,
                'choices' => [
                    "Oui" => true,
                    'Non' => false,
                ],
            ])
            ->add('img_format', TextType::class, [
                'label' => 'Quel(s) format(s) d’image souhaitez-vous (Jpg, Tiff, Png) ?',
                'label_attr' => ['class' => "form-label-misc"],
                'required' => true,
            ])
            ->add('background', ChoiceType::class, [
                'label' => 'Avec ou Sans fond transparent ?',
                'label_attr' => ['class' => "form-label-misc"],
                'required' => true,
                "expanded" => true,
                "multiple" => false,
                'choices' => [
                    "Oui" => true,
                    'Non' => false,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjectLogo::class,
        ]);
    }
}
