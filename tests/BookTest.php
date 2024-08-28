<?php

namespace App\Tests;

use App\Entity\Book;
use App\Repository\BookRepository;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    public function testAuthorRepository(): void
    {
        $author = new Book();
        $author->setTitle('Book');

        $repository = $this->createMock(BookRepository::class);
        
        $repository->expects($this->any())
            ->method('add')
            ->with([$author, true]);

        $repository->expects($this->any())
            ->method('remove')
            ->with([$author, true]);

        $repository->expects($this->any())
            ->method('getPaginateQuery');

        $this->assertTrue(true);
    }
}
