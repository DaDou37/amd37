<?php

namespace App\Service;

use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class ContactMailer
{
    public function __construct(
        private MailerInterface $mailer,
        private string $toEmail //injecter depuis les service.yaml
        ){}

    public function send(Contact $contact): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($contact->getEmail()))
            ->to($this->toEmail) // ← change ici l’adresse de réception
            ->replyTo($contact->getEmail())
            ->subject($contact->getSubject())
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'contact' => $contact,
            ]);

        $this->mailer->send($email);
    }
}
