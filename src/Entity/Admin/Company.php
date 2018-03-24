<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Company
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
     * @ORM\Column(type="date")
     */
    private $foundedAt;

    //@ORM\ManyToMany(targetEntity="User", mappedBy="company")
    /**
     * @ORM\OneToMany(targetEntity="UserCompany", mappedBy="company")
     */
    private $usersWorkingIn;



    public function __construct()
    {
        $this->usersWorkingIn = new ArrayCollection();
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getFoundedAt()
    {
        return $this->foundedAt;
    }

    /**
     * @param mixed $foundedAt
     */
    public function setFoundedAt($foundedAt): void
    {
        $this->foundedAt = $foundedAt;
    }

    /**
     * @return ArrayCollection|UserCompany[]
     */
    public function getUsersWorkingIn()
    {
        return $this->usersWorkingIn;
    }

    public function addUsersWorkingIn(User $user)
    {
        if($this->usersWorkingIn->contains($user))
            return;

        $this->usersWorkingIn[] = $user;

        $user->addCompany($this);
    }

    public function removeUsersWorkingIn(User $user){

        if(!$this->usersWorkingIn->contains($user))
            return;

        $this->usersWorkingIn->removeElement($user);

        $user->removeCompany($this);
    }


}