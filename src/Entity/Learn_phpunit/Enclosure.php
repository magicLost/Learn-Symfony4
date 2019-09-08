<?php

namespace App\Entity\Learn_phpunit;

use App\Exception\DinosaursAreRunningRampantException;
use App\Exception\NotABuffetException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Enclosure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var ArrayCollection|Security[]
     *
     * @ORM\OneToMany(targetEntity="Security", mappedBy="enclosure", cascade={"persist"})
     */
    private $securities;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Dinosaur", mappedBy="enclosure", cascade={"persist"})
     *
     */
    private $dinosaurs;


    public function __construct(bool $withBasicSecurity = false)
    {
        $this->dinosaurs = new ArrayCollection();
        $this->securities = new ArrayCollection();

        if ($withBasicSecurity) {
            $this->addSecurity(new Security('Fence', true, $this));
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getDinosaurCount(): int
    {
        return $this->dinosaurs->count();
    }

    /**
     * @return ArrayCollection
     */
    public function getDinosaurs(): ArrayCollection
    {
        return $this->dinosaurs;
    }

    public function addDinosaur(Dinosaur $dinosaur)
    {
        if (!$this->canAddDinosaur($dinosaur)) {
            throw new NotABuffetException();
        }

        if(!$this->isSecurityActive())
        {
            throw new DinosaursAreRunningRampantException('Are you craaazy?!?');
        }

        $this->dinosaurs->add($dinosaur);
        $dinosaur->setEnclosure($this);
    }

    public function addSecurity(Security $security){
        $this->securities->add($security);
    }

    private function canAddDinosaur(Dinosaur $dinosaur): bool
    {
        return
            count($this->dinosaurs) === 0
            ||
            $this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous();

    }

    public function isSecurityActive(): bool
    {
        foreach ($this->securities as $security)
        {
            if($security->getIsActive())
            {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Security[]|ArrayCollection
     */
    public function getSecurities()
    {
        return $this->securities;
    }
}