<?php

namespace App\Tests;

use App\Entity\Subject;
use App\Repository\SubjectRepository;
use PHPUnit\Framework\TestCase;

class SubjectTest extends TestCase
{
    public function testSubjectRepository(): void
    {
        $author = new Subject();
        $author->setDescription('Book description');

        $repository = $this->createMock(SubjectRepository::class);
        
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
