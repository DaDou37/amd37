<?php

namespace App\Controller;

use App\Dto\Contact;
use App\Form\ContactForm;
use App\Service\ContactMailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Controller responsible for handling contact form submissions.
 * 
 * This controller handles displaying the contact form, processing user input,
 * and sending emails using the ContactMailer service.
 */
class ContactController extends AbstractController
{
    /**
     * Display and handle the contact form.
     *
     * @param Request $request The current HTTP request.
     * @param ContactMailer $contactMailer Service responsible for sending contact emails.
     * 
     * @return Response The HTTP response object, either rendering the form or redirecting after submission.
     */
    #[Route('/contact', name: 'app_contact_index')]
    public function contact(Request $request, ContactMailer $contactMailer): Response
    {
        // Create a new Contact DTO
        $contact = new Contact();

        // Build the contact form using the DTO
        $form = $this->createForm(ContactForm::class, $contact);
        $form->handleRequest($request);

        // Handle form submission
        if ($form->isSubmitted() && $form->isValid()) {
            // Send the contact email
            $contactMailer->send($contact);

            // Add a flash message to indicate success
            $this->addFlash('success', 'Votre message a été envoyé avec succès!');

            // Redirect to the same page to avoid resubmission
            return $this->redirectToRoute('app_contact_index');
        }

        // Render the contact form template
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
