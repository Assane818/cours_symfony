<?php

namespace App\Form;

use App\DTO\ClientSearchDTO;
use App\Entity\Client;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClientSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('telephone')
            ->add('username')
            // ->add('address')
            // ->add('username', TextType::class, [
            //     'required' => false,
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Ce champ ne peut pas être vide',
            //         ]),
            //     ],
            // ])
            // ->add('createAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updateAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('users', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
            ->add('search', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClientSearchDTO::class,
        ]);
    }
}
