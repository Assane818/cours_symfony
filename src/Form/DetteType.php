<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Dette;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class DetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant', NumberType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le montant',
                    ]),
                    new Regex([
                        'pattern' => '/^\d+(\.\d{1,2})?$/',
                        'message' => 'Saisir des chiffres uniquement.',
                    ]),
                    
                ]
                ])
            // ->add('montantVerser')
            // ->add('createAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updateAt', null, [
            //     'widget' => 'single_text',
            // ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'username',
            ])
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dette::class,
        ]);
    }
}
