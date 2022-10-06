<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom_du_projet')
            ->add('Categorie')
            ->add('Description')
            ->add('Images', FileType::class, [
                "multiple" => true,
                "required" => false,
                "mapped" => false,
                'row_attr' => ['class' => 'project_imgs'],
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
