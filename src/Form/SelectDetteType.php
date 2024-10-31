<?php

namespace App\Form;

use App\Enum\StatutDette;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SelectDetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant', ChoiceType::class, [
                'choices' => [
                    'Tout' => StatutDette::All->value,
                    'Solde' => StatutDette::Solde->value,
                    'Non Solde' => StatutDette::NonSolde->value,
                ],
                'required' => false,
                'placeholder' => "Type de dette",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('Search', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
