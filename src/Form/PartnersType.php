<?php

namespace App\Form;

use App\Entity\Partners;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;

class PartnersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('partner_name', TextType::class,[
                'label' => 'Nom'
            ])
            ->add('partner_address', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('partner_city', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('partner_mail',EmailType::class, [
                'label' => 'mail'
            ])
            ->add('partner_phone', TelType::class, [
                'label' => 'Téléphone'
            ])
            ->add('partner_content', CKEditorType::class, [
                'label' => 'Présentation'
            ])
            ->add('partner_picture', FileType::class, [
                'label' => 'Télécharger'
            ])
            ->add('partner_web_link', TextType::class, [
                'label' => 'Lien internet'
            ])
            ->add('partner_referent', TextType::class, [
            'label' => 'personne référente'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partners::class,
        ]);
    }
}
