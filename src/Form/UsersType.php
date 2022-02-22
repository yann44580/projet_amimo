<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class,[
                'label' => 'email'
            ])
            ->add('roles', ChoiceType::class,[
                'expanded' => false,
                'multiple' => true,
                'choices' => [
                    'role_admin' => 'role admin',
                    'role_user' => 'role user'
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'nom de famille'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'prénom'
            ])
            ->add('birthday_date')
            ->add('address')
            ->add('city')
            ->add('picture')
            ->add('presentation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
