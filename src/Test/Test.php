<?php

namespace App\Test;


class Test
{
    private $name = 'buy';

    private $birth;

    public function __call($name, array $arguments)
    {
        $name = strtolower($name);
        if($name{1} == "e" && $name{2} == "t"){

            if($name{0} == "s"){
                $name = substr($name,3);
                $this->$name = $arguments[0];
            }else if($name{0} == "g") {
                $name = substr($name,3);
                return $this->$name;
            }else{
                throw new \Exception("Undefine method.");
            }

        }else{
            throw new \Exception("Undefine method.");
        }

    }
}