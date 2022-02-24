<?php

namespace App\Form;

use App\Entity\Blogs;
use App\Entity\BlogCategories;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BlogsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('blog_title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('blog_subtitle', TextType::class, [
                'label' => 'Sous-titre'
            ])
            ->add('blog_content', CKEditorType::class, [
                'label' => 'Contenu'
            ])
            ->add('blog_author', TextType::class, [
                'label' => 'Auteur'
            ])
            ->add('blog_publication_date', DateType::class, [
                'widget' => 'single_text', 
                'label' => "Date de publication de l'article"
            ])
            ->add('blog_category', EntityType::class, [
                'class' => BlogCategories::class,
                'label' => "Catégorie de l'article",
                'choice_label' => 'blog_category_name',
                // 'multiple' => true,
                // 'expanded' => false
            ])
            ->add('picturesBlogs', FileType::class, [
                'label' => 'Photo',
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blogs::class,
        ]);
    }
}
