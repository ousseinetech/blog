<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
       return $crud->setDefaultSort(['published_at' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
       return $actions
          ->disable(Action::EDIT)
          ->add(Crud::PAGE_INDEX, Action::DETAIL)
          ;
    }

    public function configureFilters(Filters $filters): Filters
    {
       return $filters
          ->add('username')
          ->add('email')
       ;
    }

   public function configureFields(string $pageName): iterable
    {
       return [
          TextField::new('username'),
          TextField::new('email')->onlyOnDetail(),
          DateField::new('published_at'),
          TextEditorField::new('content')->onlyOnDetail(),
       ];
    }
}
