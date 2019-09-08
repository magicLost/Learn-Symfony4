<?php

namespace App\Entity\Learn_phpunit;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Dinosaur
{
    const LARGE = 10;
    const HUGE = 30;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $length = 0;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $genus;
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isCarnivorous;

    /**
     * @var Enclosure
     *
     * @ORM\ManyToOne(targetEntity="Enclosure", inversedBy="dinosaurs")
     */
    private $enclosure;

    public function __construct(string $genus = 'Unknown', bool $isCarnivorous = false)
    {
        $this->genus = $genus;
        $this->isCarnivorous = $isCarnivorous;
    }


    public function getSpecification()
    {

        return sprintf(
            'The %s %scarnivorous dinosaur is %d meters long',
            $this->genus,
            $this->isCarnivorous ? '' : 'non-',
            $this->length
        );
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    /**
     * @return string
     */
    public function getGenus(): string
    {
        return $this->genus;
    }

    /**
     * @param string $genus
     */
    public function setGenus(string $genus): void
    {
        $this->genus = $genus;
    }

    /**
     * @return bool
     */
    public function isCarnivorous(): bool
    {
        return $this->isCarnivorous;
    }

    public function setIsCarnivorous(bool $is): void
    {
        $this->isCarnivorous = $is;
    }

    public function setEnclosure(Enclosure $enclosure)
    {
        $this->enclosure = $enclosure;
    }

}