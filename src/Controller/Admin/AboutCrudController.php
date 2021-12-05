<?php

namespace App\Controller\Admin;

use App\Entity\About;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AboutCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return About::class;
    }

    public function configureActions(Actions $actions): Actions
    {
       return $actions
          #->remove(Crud::PAGE_INDEX, Action::INDEX)
          ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

   public function configureFields(string $pageName): iterable
    {
        return [
            TextareaField::new('content')->onlyOnDetail(),
            TextEditorField::new('content')->hideOnDetail(),
        ];
    }
}
