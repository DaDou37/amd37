<?php

namespace App\Controller;

use App\Entity\Testimonial;
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
            // Récupérer le prénom depuis le formulaire
            $firstName = $form->get('firstName')->getData();
            // Concaténer prénom + nom dans author
            $testimonial->setAuthor($firstName . ' ' . $testimonial->getAuthor());

            $testimonial->setIsApproved(false);
            $testimonial->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($testimonial);
            $entityManager->flush();

            $this->addFlash('success', 'Merci pour votre avis !');
            return $this->redirectToRoute('app_testimonial_index');
        }

        // Récupérer uniquement les avis approuvés
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
            'form' => $form->createView(), 
        ]);
    }

    #[Route('/ajouter', name: 'app_testimonial_public_new', methods: ['GET', 'POST'])]
    public function publicNew(Request $request, EntityManagerInterface $em): Response
    {
        $testimonial = new Testimonial();
        $form = $this->createForm(TestimonialPublicFormType::class, $testimonial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $firstName = $form->get('firstName')->getData();
            $testimonial->setAuthor($firstName . ' ' . $testimonial->getAuthor());

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
}
