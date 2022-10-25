<?php

namespace App\Form;

use App\Entity\Devis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DevisFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // essai upload
        ->add('Images', FileType::class, [
            'label' => 'Uploader votre devis en pdf',
            "multiple" => true,
            "required" => false,
            "mapped" => false,
            'row_attr' => ['class' => 'devis_imgs'],
        ])
        ->add('reference', TextType::class, [
            'label' => 'Référence (à remplir obligatoirement)',
            'label_attr' => ['class' => "form-label"],
            'attr' => ['placeholder' => 'Nom du projet lié au devis','maxlength' => 75],
            'required' => false,
        ])
        ->add('date_redaction', DateType::class, [
            'label' => 'Date de rédaction du devis :',
            'label_attr' => ['class' => "form-label"],
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'required' => false,
        ])
        ->add('duree_validite', DateType::class, [
            'label' => 'Date de validité du devis :',
            'label_attr' => ['class' => "form-label"],
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'required' => false,
        ])
            ->add('detail', TextareaType::class, [
                'label' => 'Détail des prestations',
                'label_attr' => ['class' => "form-label"],
                'required' => false,
            ])
            ->add('prix_ht', TextType::class, [
                'label' => 'Prix HT :',
                'label_attr' => ['class' => "form-label"],
                'required' => false,
            ])
            ->add('prix_ttc', TextType::class, [
                'label' => 'Prix TTC :',
                'label_attr' => ['class' => "form-label"],
                'required' => false,
            ])
            ->add('raison_Social', TextType::class, [
                'label' => 'Raison sociale :',
                'required' => false,
            ])
            ->add('adresse', AddressFormType::class,[
            ])
            ->add('siret', TextType::class, [
                'label' => 'N° de siret :',
                'required' => false,
                'attr' => ['maxlength' => 14],
                'constraints' => [
                    new Regex([
                        'pattern'=> '/^[0-9]{14}$/',
                        'match'=> true,
                        'message'=> 'Veuillez entrer un numéro valide',
                    ]),
                
            // ->add('User')
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}