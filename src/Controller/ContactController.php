<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactForm;
use App\Service\ContactMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Controller responsible for handling the contact form and sending emails.
 */
#[Route('/contact')]
final class ContactController extends AbstractController
{
    /**
     * Displays the contact form and handles its submission.
     *
     * @param Request $request The HTTP request.
     * @param EntityManagerInterface $entityManager Used to persist contact entries.
     * @param ContactMailer $contactMailer Service responsible for sending the contact email.
     * @param ParameterBagInterface $params Used to retrieve configuration parameters (e.g. reCAPTCHA key).
     *
     * @return Response The contact page with the form view.
     */
    #[Route(name: 'app_contact_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        ContactMailer $contactMailer,
        ParameterBagInterface $params
    ): Response {
        // Create a new Contact entity and bind it to the form (without user field)
        $contact = new Contact();
        $form = $this->createForm(ContactForm::class, $contact, [
            'include_user' => false,
        ]);
        $form->handleRequest($request);

        // If form is valid, persist the data and send an email
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            // Send the contact email using the custom mailer service
            $contactMailer->send($contact);

            $this->addFlash('success', 'Votre message a bien été envoyé !');
            return $this->redirectToRoute('app_contact_index');
        }

        // Render the contact form with reCAPTCHA configuration
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'karser_recaptcha3_site_key' => $params->get('recaptcha_site_key'),
            'karser_recaptcha3_enabled' => true,
        ]);
    }
}
