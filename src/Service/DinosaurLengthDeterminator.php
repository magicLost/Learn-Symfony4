<?php
/**
 * Created by PhpStorm.
 * User: Nikki
 * Date: 06.04.2018
 * Time: 18:43
 */

namespace App\Service;


use App\Entity\Learn_phpunit\Dinosaur;

class DinosaurLengthDeterminator
{
    public function getLengthFromSpecification(string $specification): int
    {
        $availableLengths = [
            'huge' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'omg' => ['min' => Dinosaur::HUGE, 'max' => 100],
            '😱' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'large' => ['min' => Dinosaur::LARGE, 'max' => Dinosaur::HUGE - 1],
        ];
        $minLength = 1;
        $maxLength = Dinosaur::LARGE - 1;
        foreach (explode(' ', $specification) as $keyword) {
            $keyword = strtolower($keyword);
            if (array_key_exists($keyword, $availableLengths)) {
                $minLength = $availableLengths[$keyword]['min'];
                $maxLength = $availableLengths[$keyword]['max'];
                break;
            }
        }
        return random_int($minLength, $maxLength);
    }
}