<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('author')
            ->add('summary')
            ->add('content', CKEditorType::class, [
               'config_name' => 'author_config',
            ])
            ->add('imageFile', FileType::class, [
               'required' => false,
            ])
            ->add('published_at', null, [
               'attr' => ['class' => 'js-datepicker'],
               'required' => false,
               'label' => 'Date de publication',
               'widget' => 'single_text',
               'html5' => false,
               'format' => 'MM/dd/yyyy'
            ])
            ->add('is_published')
            ->add('categories', EntityType::class, [
               'required' => false,
               'class' => Category::class,
               'choice_label' => 'name',
               'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
