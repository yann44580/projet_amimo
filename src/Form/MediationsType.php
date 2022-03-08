<?php

namespace App\Form;

use App\Entity\Mediations;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mediation_history', CKEditorType::class)
            ->add('mediation_pedagogy', CKEditorType::class)
            ->add('mediation_biography', CKEditorType::class)
            ->add('mediation_definition', CKEditorType::class)
            ->add('mediation_objectif', CKEditorType::class)
            ->add('mediation_methods', CKEditorType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mediations::class,
        ]);
    }
}
