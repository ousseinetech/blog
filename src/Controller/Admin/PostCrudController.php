<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
       return $crud
          ->setSearchFields(['title', 'categories'])
          ->setDefaultSort(['published_at' => 'DESC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
       return $filters
          ->add('categories')
          ->add('created_at')
          ->add('published_at');
    }

   public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            ImageField::new('image_name')
               ->setBasePath($this->getParameter('app.path.post_image'))
               ->onlyOnIndex()
               ->setLabel('Image'),
            AssociationField::new('categories')->hideOnIndex(),
            TextareaField::new('summary')->hideOnIndex(),
            DateField::new('published_at')->hideWhenCreating(),
            Field::new('is_published'),
            TextareaField::new('imageFile')
               ->setLabel('Image')
               ->hideOnIndex()
               ->setFormType(VichImageType::class),
            TextareaField::new('content')->hideOnIndex(),
        ];
    }
}
