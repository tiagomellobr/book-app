<?php

namespace App\Twig\Components;

use App\Repository\BookRepository;
use App\Utils\Paginator;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PostMount;

#[AsTwigComponent]
final class Books
{
    public $books;
    public int $page;
    public int $limit = 6;

    public function __construct(
        public Paginator $paginator,
        private BookRepository $bookRepository
    ) {}

    #[PostMount()]
    public function getData()
    {
        $query = $this->bookRepository->getPaginateQuery();
        $this->paginator->paginate($query, $this->page, $this->limit);
    }
}
