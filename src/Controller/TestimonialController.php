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
    /**
     * Displays the list of approved testimonials with pagination.
     * Also handles the submission of the public testimonial form on the same page.
     *
     * @param TestimonialRepository $testimonialRepository The repository for testimonials.
     * @param PaginatorInterface $paginator Paginator for paginating testimonials.
     * @param Request $request HTTP request instance.
     * @param EntityManagerInterface $entityManager Doctrine entity manager.
     *
     * @return Response Rendered testimonial list with form.
     */
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
            // Mark as not approved by default
            $testimonial->setIsApproved(false);
            $testimonial->setCreatedAt(new \DateTimeImmutable());

            // Persist the new testimonial to database
            $entityManager->persist($testimonial);
            $entityManager->flush();

            $this->addFlash('success', 'Merci pour votre avis !');
            return $this->redirectToRoute('app_testimonial_index');
        }

        // Fetch only approved testimonials and paginate
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

    /**
     * Alternative route to allow public users to submit a testimonial via separate form page.
     *
     * @param Request $request HTTP request containing the form.
     * @param EntityManagerInterface $em Doctrine entity manager.
     *
     * @return Response Rendered form page or redirection after submission.
     */
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
}
