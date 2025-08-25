<?php

namespace App\Service;

use App\Dto\Contact;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

/**
 * Service responsible for sending contact emails.
 * 
 * This class leverages Symfony's Mailer component to send emails
 * based on the data provided by the Contact Data Transfer Object (DTO).
 */
class ContactMailer
{
    /**
     * Constructor.
     *
     * @param MailerInterface $mailer The mailer service used to send emails.
     * @param string $toEmail The recipient email address (typically the admin or support email).
     */
    public function __construct(
        private MailerInterface $mailer,
        private string $toEmail
    ) {}

    /**
     * Sends an email using the information provided by a Contact DTO.
     *
     * @param Contact $contact The contact data containing the sender's email, subject, and message.
     *
     * This method creates a TemplatedEmail, sets the sender, recipient, reply-to address,
     * subject, and renders the email content using a Twig template.
     */
    public function send(Contact $contact): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($contact->getEmail()))      // Sender's email address
            ->to($this->toEmail)                           // Recipient's email address
            ->replyTo($contact->getEmail())                // Reply-to address
            ->subject($contact->getSubject())             // Email subject
            ->htmlTemplate('emails/contact.html.twig')    // Twig template for email body
            ->context([
                'contact' => $contact,                    // Passing the DTO to the template
            ]);

        $this->mailer->send($email);
    }
}
