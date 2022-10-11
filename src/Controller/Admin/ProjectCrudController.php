<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Projets')
            ->setEntityLabelInSingular('projet')
            ->setPageTitle('index', 'gestion des projets');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnIndex()
            ->hideOnForm(),
            TextField::new('Nom_Du_Projet'),
            TextField::new('Categorie'),
            TextEditorField::new('description'),
            ChoiceField::new('Statut'),
        ];
    }
}