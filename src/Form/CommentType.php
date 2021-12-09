<?php

namespace App\Form;

use App\Entity\Comment;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options)
   {
      $builder
         ->add('username', TextType::class)
         ->add('email', EmailType::class)
         ->add('content', TextareaType::class, [
            'attr' => ['rows' => 8]
         ])
         ->add('rgpd', null, [
            'label' => 'Accepte les conditions de confidentialités'
         ])
      ;
   }

   public function configureOptions(OptionsResolver $resolver)
   {
      $resolver->setDefaults([
         'class' => Comment::class,
         'translation_domain' => 'forms'
      ]);
   }
}