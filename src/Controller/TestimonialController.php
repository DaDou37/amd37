<?php

namespace App\Controller;

use App\Entity\Testimonial;
use App\Form\TestimonialForm;
use App\Form\TestimonialPublicFormType;
use App\Repository\TestimonialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/avis')]
final class TestimonialController extends AbstractController
{
#[Route(name: 'app_testimonial_index', methods: ['GET', 'POST'])]
public function index(
    TestimonialRepository $testimonialRepository,
    PaginatorInterface $paginator,
    Request $request,
    EntityManagerInterface $entityManager
): Response {
    $testimonial = new Testimonial();
    $form = $this->createForm(TestimonialPublicFormType::class, $testimonial);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $testimonial->setIsApproved(false);
        $testimonial->setCreatedAt(new \DateTimeImmutable());
        $entityManager->persist($testimonial);
        $entityManager->flush();
            dump('Form submitted');
    dump($request->request->all());
    dump($form->getData());

        $this->addFlash('success', 'Merci pour votre avis !');
        return $this->redirectToRoute('app_testimonial_index');
    }

    $query = $testimonialRepository->createQueryBuilder('t')
        ->where('t.isApproved = true')
        ->orderBy('t.createdAt', 'DESC')
        ->getQuery();

    $testimonials = $paginator->paginate(
        $query,
        $request->query->getInt('page', 1),
        6
    );

    return $this->render('testimonial/index.html.twig', [
        'testimonials' => $testimonials,
        'form' => $form->createView(), // 👈 C’est cette ligne qui est obligatoire
    ]);
}

    #[Route('/ajouter', name: 'app_testimonial_public_new', methods: ['GET', 'POST'])]
    public function publicNew(Request $request, EntityManagerInterface $em): Response
    {
        $testimonial = new Testimonial();
        $form = $this->createForm(TestimonialPublicFormType::class, $testimonial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testimonial->setIsApproved(false);
            $testimonial->setCreatedAt(new \DateTimeImmutable());
            $em->persist($testimonial);
            $em->flush();

            $this->addFlash('success', 'Merci pour votre avis ! Il sera publié après validation.');
            return $this->redirectToRoute('app_testimonial_index');
        }

        return $this->render('testimonial/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_testimonial_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $testimonial = new Testimonial();
        $form = $this->createForm(TestimonialForm::class, $testimonial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = (string) $form->getErrors(true, false);
            $this->addFlash('danger', 'Erreur dans le formulaire : ' . $errors);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($testimonial);
            $entityManager->flush();

            return $this->redirectToRoute('app_testimonial_index');
        }

        return $this->render('testimonial/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_testimonial_show', methods: ['GET'])]
    public function show(Testimonial $testimonial): Response
    {
        return $this->render('testimonial/show.html.twig', [
            'testimonial' => $testimonial,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_testimonial_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Testimonial $testimonial, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(TestimonialForm::class, $testimonial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_testimonial_index');
        }

        return $this->render('testimonial/edit.html.twig', [
            'testimonial' => $testimonial,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_testimonial_delete', methods: ['POST'])]
    public function delete(Request $request, Testimonial $testimonial, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $testimonial->getId(), $request->request->get('_token'))) {
            $entityManager->remove($testimonial);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_testimonial_index');
    }
}
