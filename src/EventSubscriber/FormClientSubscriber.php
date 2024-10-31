<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class FormClientSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(MailerInterface $mailer,)
    {
        $this->mailer = $mailer;
    }

    public function onFormPostSubmit(PostSubmitEvent $event): void
    {
        $formData = $event->getData();
        $form = $event->getForm();
        $user = $formData->getUsers();
        if ($form->isValid()) {
            $file = $form->get('users')->get('image')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid() . '.' . $file->guessExtension();
                $uploadsDirectory = '/home/assane/symfony/gestion_dette/public/img';
                $file->move(
                    $uploadsDirectory,
                    $newFilename
                );
                $user->setImage($newFilename);
            }
            // Création de l'email
            $email = (new Email())
            ->from('assanen818@gmail.com')
            ->to($user->getLogin())
            ->subject('Bienvenue sur notre boutique SuperflyShop !')
            ->text("Bonjour {$user->getNom()},\n\nMerci de vous être inscrit sur notre boutique SuperflyShop!");
            $this->mailer->send($email);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'form.post_submit' => 'onFormPostSubmit',
        ];
    }
}

