<?php

namespace App\Entity\Learn_phpunit;

use Doctrine\ORM\Mapping as ORM;


/**
* @ORM\Entity
*/
class Security
{
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    private $id;
    /**
    * @ORM\Column(type="string")
    */
    private $name;
    /**
    * @ORM\Column(type="boolean")
    */
    private $isActive;

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @param mixed $enclosure
     */
    public function setEnclosure($enclosure): void
    {
        $this->enclosure = $enclosure;
    }
    /**
    * @ORM\ManyToOne(targetEntity="Enclosure", inversedBy="securities")
    */
    private $enclosure;

    public function __construct(string $name = '', bool $isActive = false, Enclosure $enclosure = null)
    {
        $this->name = $name;
        $this->isActive = $isActive;
        $this->enclosure = $enclosure;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }
}