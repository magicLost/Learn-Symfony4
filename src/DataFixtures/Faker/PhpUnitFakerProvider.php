<?php

namespace App\DataFixtures\Faker;


use Faker\Provider\Base;

class PhpUnitFakerProvider extends Base
{
    public function dinosaurName()
    {
        $name = [

            'Velociraptor',
            'Triceratops',
            "T-rex"

        ];

        return $name[rand(0, count($name) - 1)];
    }

    public function securityName()
    {
        $name = [

            'Tower defence',
            'Muchine gun',
            "Electric fence"

        ];

        return $name[rand(0, count($name) - 1)];
    }
}