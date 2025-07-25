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

#[Route('/contact')]
final class ContactController extends AbstractController
{
    #[Route(name: 'app_contact_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        ContactMailer $contactMailer,
        ParameterBagInterface $params
    ): Response {
        $contact = new Contact();
        $form = $this->createForm(ContactForm::class, $contact, [
            'include_user' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            $contactMailer->send($contact);

            $this->addFlash('success', 'Votre message a bien été envoyé !');
            return $this->redirectToRoute('app_contact_index');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'karser_recaptcha3_site_key' => $params->get('recaptcha_site_key'),
            'karser_recaptcha3_enabled' => true,
        ]);
    }
}
