<?php

namespace App\Form;

use App\Entity\Tools;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToolsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tool_title')
            ->add('tool_content')
            ->add('tool_picture')
            ->add('tool_publication_date')
            ->add('tool_author')
            ->add('animal_category')
            ->add('user')
            ->add('category_tool')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tools::class,
        ]);
    }
}
