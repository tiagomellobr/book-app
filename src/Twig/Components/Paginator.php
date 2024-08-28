<?php

namespace App\Twig\Components;

use App\Utils\Paginator as UtilsPaginator;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Paginator
{
    public UtilsPaginator $paginator;
}
