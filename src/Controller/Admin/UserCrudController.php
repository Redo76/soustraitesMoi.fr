<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Utilisateurs')
            ->setEntityLabelInSingular('Utilisateur')
            ->setPageTitle('index', 'gestion des utilisateurs');
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnIndex()
            ->hideOnForm(),
            TextField::new('firstName')
            ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('lastName')
            ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('password')
            ->hideOnIndex()
            ->hideOnForm(),
            TextField::new('avatar')
            ->hideOnIndex()
            ->hideOnForm(),
            TextField::new('phone')
            ->setFormTypeOption('disabled', 'disabled'),
            IdField::new('GoogleId')
            ->hideOnIndex()
            ->hideOnForm(),
            TextField::new('Siret')
            ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('CompanyName')
            ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('CompanyCommercialName')
            ->setFormTypeOption('disabled', 'disabled'),
        ];
    }
    
}
