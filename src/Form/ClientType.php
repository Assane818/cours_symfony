<?php

namespace App\Form;

use App\Entity\Client;
use App\EventSubscriber\FormClientSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('telephone', TextType::class, [
                'required' => false
            ])
            ->add('address')
            ->add('username')
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
            ->add('users', UserType::class)
            ->add('save', SubmitType::class);
            $builder->addEventSubscriber(new FormClientSubscriber($this->mailer));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
