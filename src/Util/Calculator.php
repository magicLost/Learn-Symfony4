<?php

namespace App\Util;


class Calculator
{

    public function add(float $a, float $b): float{

        return $a + $b;

    }

    public function divide(float $a, float $b): float{

        if($b == 0){
            throw new \Exception('Divide by zero');
        }

        return $a / $b;

    }

}