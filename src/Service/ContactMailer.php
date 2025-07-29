<?php

namespace App\Service;

use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 * Service responsible for sending contact form emails.
 * Utilizes Symfony Mailer and Twig templates to format the email.
 */
class ContactMailer
{
    /**
     * Constructor to inject dependencies.
     *
     * @param MailerInterface $mailer Symfony Mailer service for sending emails
     * @param string $toEmail Recipient email address, configured in service.yaml
     */
    public function __construct(
        private MailerInterface $mailer,
        private string $toEmail
    ) {}

    /**
     * Sends an email based on the Contact entity data.
     *
     * @param Contact $contact The contact message entity containing sender data
     */
    public function send(Contact $contact): void
    {
        // Create a new templated email using Twig template and contact info
        $email = (new TemplatedEmail())
            ->from(new Address($contact->getEmail()))      // Sender email from contact form
            ->to($this->toEmail)                            // Recipient email (site admin, for example)
            ->replyTo($contact->getEmail())                 // Reply-to set to sender's email
            ->subject($contact->getSubject())               // Email subject from contact form
            ->htmlTemplate('emails/contact.html.twig')      // Twig template to format the email
            ->context([
                'contact' => $contact,                       // Pass the contact entity to the template
            ]);

        // Send the email via the injected mailer service
        $this->mailer->send($email);
    }
}
