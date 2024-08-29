<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use App\Utils\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    #[Route('/admin/authors', name: 'app_author')]
    public function index(
        Request $request,
        Paginator $paginator,
        AuthorRepository $authorRepository
    ): Response
    {
        $query = $authorRepository->getPaginateQuery();
        $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('author/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }

    #[Route('/admin/author/form/{id?}', name: 'app_author_form')]
    public function form(
        Author $author = null,
        AuthorRepository $authorRepository,
        Request $request,
    ): Response
    {
        $author = $author ?? new Author();

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $authorRepository->add($author, true);

            $this->addFlash(
                'success', 'Your author has been saved successfully!'
            );

            return $this->redirectToRoute('app_author');
        }

        return $this->render('author/form.html.twig', [
            'form' => $form->createView(),
        ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200));
    }

    #[Route('/admin/author/delete/{id}', name: 'app_author_delete', methods: ['POST'])]
    public function delete(
        Author $author,
        AuthorRepository $authorRepository,
    ): Response
    {
        $authorRepository->remove($author, true);

        $this->addFlash(
            'success', 'Your author has been deleted successfully!'
        );

        return $this->redirectToRoute('app_author');
    }
}
