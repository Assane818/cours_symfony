<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, [
                'required' => false,
                
            ])
            ->add('prenom',TextType::class, [
                'required' => false,
                
            ])
            ->add('login',TextType::class, [
                'required' => false,
                
            ])
            ->add('password',TextType::class, [
                
            ])
            ->add('image', FileType::class, [
                'required' => false,
            ])
            // ->add('createAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updateAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('isBlocked')
            // ->add('client', EntityType::class, [
            //     'class' => Client::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
