<?php

namespace App\Form;

use App\Entity\Animals;
use App\Entity\AnimalsCategories;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AnimalsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('animal_name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('animal_picture', FileType::class, [
                'label' => 'Photo',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],

                        'mimeTypesMessage' => 'Veuillez entrer un format de document valide',
                    ])
                ],
            ])
            ->add('animal_content', CKEditorType::class, [
                'label' => 'Présentation'
            ])
            ->add('animal_category', EntityType::class, [
                'class' => AnimalsCategories::class,
                'label' => 'Catégorie animal',
                'choice_label' => 'animal_category_name',
                'multiple' => false,
                'expanded' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animals::class,
        ]);
    }
}
