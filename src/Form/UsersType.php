<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\File;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'email'
            ])
            ->add('roles', ChoiceType::class, [
                'expanded' => false,
                'multiple' => true,
                'choices' => [
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_USER' => 'ROLE_USER'
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'nom de famille'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'prénom'
            ])
            ->add('birthday_date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('address', TextType::class, [
                'label' => 'adresse'
            ])
            ->add('city', TextType::class, [
                'label' => 'ville'
            ])
            ->add('picture', FileType::class, [
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
            ->add('presentation', CKEditorType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
