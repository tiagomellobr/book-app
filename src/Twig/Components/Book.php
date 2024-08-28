<?php

namespace App\Twig\Components;

use App\Entity\Book as EntityBook;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Book
{
    public EntityBook $book;
}
