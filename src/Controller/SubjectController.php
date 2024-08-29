<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use App\Repository\SubjectRepository;
use App\Utils\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubjectController extends AbstractController
{
    #[Route('/admin/subjects', name: 'app_subject')]
    public function index(
        Request $request,
        Paginator $paginator,
        SubjectRepository $subjectRepository
    ): Response
    {
        $query = $subjectRepository->getPaginateQuery();
        $paginator->paginate($query, $request->query->getInt('page', 1), 10);

        return $this->render('subject/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }

    #[Route('/admin/subject/form/{id?}', name: 'app_subject_form')]
    public function form(
        Subject $subject = null,
        SubjectRepository $subjectRepository,
        Request $request,
    ): Response
    {
        $subject = $subject ?? new Subject();

        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            try {
                $subjectRepository->add($subject, true);
            } catch (\Error $error) {

                $this->addFlash(
                    'error', $error->getMessage()
                );

                return $this->redirectToRoute('app_subject_form', [
                    'id' => $subject->getId()
                ]);
            }

            $this->addFlash(
                'success', 'Your subject has been saved successfully!'
            );

            return $this->redirectToRoute('app_subject');
        }

        return $this->render('subject/form.html.twig', [
            'form' => $form->createView(),
        ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200));
    }

    #[Route('/admin/subject/delete/{id}', name: 'app_subject_delete', methods: ['POST'])]
    public function delete(
        Subject $subject,
        SubjectRepository $subjectRepository,
    ): Response
    {
        try {
            $subjectRepository->remove($subject, true);
        } catch (\Error $error) {
            $this->addFlash(
                'error', $error->getMessage()
            );

            return $this->redirectToRoute('app_subject');
        }

        $this->addFlash(
            'success', 'Your subject has been deleted successfully!'
        );

        return $this->redirectToRoute('app_subject');
    }
}
