<?php

namespace App\Tests;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{
    public function testAuthorRepository(): void
    {
        $author = new Author();
        $author->setName('Author');

        $repository = $this->createMock(AuthorRepository::class);
        
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
