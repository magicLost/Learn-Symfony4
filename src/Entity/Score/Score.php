<?php

namespace App\Entity\Score;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Score\ScoreRepository")
 */
class Score
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45, unique=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $real_name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private $score;


    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;


    /**
     * @ORM\OneToMany(targetEntity="ScoreComment", mappedBy="score")
     * @ORM\OrderBy({"createdAt"="DESC"})
     */
    private $comments;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }


    //SETTERS AND GETTERS

    /**
     * @return ArrayCollection|ScoreComment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return mixed
     */
    public function getisActive()
    {
        return $this->isActive;
    }

    /**
     * @param int $score
     */
    public function setScore($score): void
    {
        $this->score = $score;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return new \DateTime('-'.rand(0, 100).' days');
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return mixed
     */
    public function getRealName()
    {
        return $this->real_name;
    }

    /**
     * @param mixed $real_name
     */
    public function setRealName($real_name): void
    {
        $this->real_name = $real_name;
    }

}
