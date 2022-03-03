<?php

namespace App\Form;

use App\Entity\Associations;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class AssociationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('association_name', TextType::class)
            ->add('association_address', TextType::class)
            ->add('association_city', TextType::class)
            ->add('association_mail', EmailType::class)
            ->add('association_phone', TelType::class)
            ->add('association_content', CKEditorType::class)
            ->add('picturesAssociations', FileType::class, [
                'label' => 'Photos',
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('association_logo', FileType::class, [
                'label' => 'logo',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Associations::class,
        ]);
    }
}
