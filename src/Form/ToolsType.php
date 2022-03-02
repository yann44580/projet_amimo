<?php

namespace App\Form;

use App\Entity\Tools;
use App\Entity\Populations;
use App\Entity\ToolCategories;
use App\Entity\PopulationsType;
use App\Entity\AnimalsCategories;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ToolsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tool_title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('tool_content', CKEditorType::class, [
                'label' => 'Contenu'
            ])
            ->add('tool_publication_date', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('tool_author', TextType::class, [
                'label' => 'Auteur'
            ])
            ->add('animal_category', EntityType::class, [
                'class' => AnimalsCategories::class,
                'label' => "Catégorie de l'animal",
                'choice_label' => 'animal_category_name',
                'multiple' => true,
                'expanded' => false
            ])
            // ->add('user')
            ->add('category_tool', EntityType::class, [
                'class' => ToolCategories::class,
                'label' => "Catégorie de l'outil",
                'choice_label' => 'tool_category_name'
            ])
            ->add('populations', EntityType::class, [
                'class' => Populations::class,
                'label' => "Type de public",
                'choice_label' => 'population_name',
                'multiple' => true,
                'expanded' => false

            ])
            ->add('picturesTools', FileType::class, [
                'label' => 'Photos',
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('population_type', EntityType::class, [
                'class' => PopulationsType::class, 
                'label' => "Catégories de public",
                'choice_label' => 'population_type_name',
                'multiple' => true,
                'expanded' => false
            ])
            ->add('size_group', ChoiceType::class, [
                'expanded' => false,
                'multiple' => false,
                'label' => 'Type de séance',
                'choices' => [
                    'Groupe' => 'Groupe',
                    'Individuelle' => 'Individuelle'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tools::class,
        ]);
    }
}
