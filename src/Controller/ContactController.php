<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactForm;
use App\Service\ContactMailer;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/contact')]
final class ContactController extends AbstractController
{
#[Route(name: 'app_contact_index', methods: ['GET', 'POST'])]
public function index(
    Request $request,
    EntityManagerInterface $entityManager,
    ContactRepository $contactRepository,
    ContactMailer $contactMailer
): Response {
    $contact = new Contact();
    $form = $this->createForm(ContactForm::class, $contact, [
        'include_user' => false,
    ]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($contact);
        $entityManager->flush();

        // ✅ Envoi de l’email ici
        $contactMailer->send($contact);

        $this->addFlash('success', 'Votre message a bien été envoyé !');
        return $this->redirectToRoute('app_contact_index');
    }

    return $this->render('contact/index.html.twig', [
        'contacts' => $contactRepository->findAll(),
        'form' => $form->createView(),
        'recaptcha_site_key' => $this->getParameter('recaptcha_site_key'),
    ]);
}


    #[Route('/new', name: 'app_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ContactMailer $contactMailer): Response
    {
        $contact = new Contact(); // createdAt est automatiquement défini dans l'entité

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

        return $this->render('contact/new.html.twig', [
            'form' => $form->createView(), // ✅ important !
        ]);
    }

    #[Route('/{id}', name: 'app_contact_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactForm::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}
