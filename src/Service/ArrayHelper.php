<?php

namespace App\Service;


class ArrayHelper
{
    public function sortArrayByNames(array $arr) : array
    {
        $result = [];

        foreach($arr as $array){

            $result[$array['name']][] = $array;

        }

        return $result;
    }
}