<?php

namespace App\Controller\Admin;

use App\Entity\Banner;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BannerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Banner::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('name'),
            ImageField::new('image_name')
               ->onlyOnIndex()
               ->setBasePath($this->getParameter('app.path.banner_image')),
            TextareaField::new('imageFile')
               ->setLabel('Image')
               ->setFormType(VichImageType::class)
               ->hideOnIndex(),
            TextareaField::new('description'),

        ];
    }
}
