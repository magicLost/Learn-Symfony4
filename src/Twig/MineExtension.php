<?php

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MineExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('stars', [$this, 'addStarsFilter']),
        ];
    }

    public function addStarsFilter(string $string) : string
    {
        return $string = '*'.$string.'*';
    }
}