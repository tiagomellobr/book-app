<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Utils\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/admin/books', name: 'app_book')]
    public function index(
        Request $request,
        Paginator $paginator,
        BookRepository $bookRepository
    ): Response
    {
        $query = $bookRepository->getPaginateQuery();
        $paginator->paginate($query, $request->query->getInt('page', 1), 10);

        return $this->render('book/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }

    #[Route('/admin/book/form/{id?}', name: 'app_book_form')]
    public function form(
        Book $book = null,
        BookRepository $bookRepository,
        Request $request,
    ): Response
    {
        $book = $book ?? new Book();

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            try {
                $bookRepository->add($book, true);
            } catch (\Error $error) {

                $this->addFlash(
                    'error', $error->getMessage()
                );

                return $this->redirectToRoute('app_book_form', [
                    'id' => $book->getId()
                ]);
            }

            $this->addFlash(
                'success', 'Your book has been saved successfully!'
            );

            return $this->redirectToRoute('app_book');
        }

        return $this->render('book/form.html.twig', [
            'form' => $form->createView(),
        ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200));
    }

    #[Route('/admin/book/delete/{id}', name: 'app_book_delete', methods: ['POST'])]
    public function delete(
        Book $book,
        BookRepository $bookRepository,
    ): Response
    {
        try {
            $bookRepository->remove($book, true);
        } catch (\Error $error) {
            $this->addFlash(
                'error', $error->getMessage()
            );

            return $this->redirectToRoute('app_book');
        }

        $this->addFlash(
            'success', 'Your book has been deleted successfully!'
        );

        return $this->redirectToRoute('app_book');
    }
}
