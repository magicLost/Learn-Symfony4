<?php

namespace App\Entity\Admin;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Entity\Admin\Company;


/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\UserRepository")
 */
class User
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
     * @ORM\Column(type="string")
     */
    private $region;
    /**
     * @ORM\Column(type="integer")
     */
    private $tall;
    /**
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime")
     */
    private $born;

    /**
     * @ORM\Column(type="string", unique=true)
     *
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEverWorking;

    //@ORM\ManyToMany(targetEntity="Company", inversedBy="usersWorkingIn")
    //@ORM\JoinTable(name="user_company")
    /**
     * @ORM\OneToMany(targetEntity="UserCompany", mappedBy="user", orphanRemoval=true)
     */
    private $company;



    public function __construct()
    {
        $this->company = new ArrayCollection();
    }


    /**
     * @return integer
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
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region): void
    {
        $this->region = $region;
    }

    /**
     * @return mixed
     */
    public function getTall()
    {
        return $this->tall;
    }

    /**
     * @param mixed $tall
     */
    public function setTall($tall): void
    {
        $this->tall = $tall;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }


    /**
     * @return mixed
     */
    public function getisActive()
    {
        return $this->isActive;
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
    public function getBorn()
    {
        return $this->born;
    }

    /**
     * @param mixed $born
     */
    public function setBorn($born): void
    {
        $this->born = $born;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getisEverWorking()
    {
        return $this->isEverWorking;
    }

    /**
     * @param mixed $isEverWorking
     */
    public function setIsEverWorking($isEverWorking): void
    {
        $this->isEverWorking = $isEverWorking;
    }

    public function addCompany(Company $company)
    {
        if($this->company->contains($company))
            return;

        $this->company[] = $company;

        //not needed for persistance but help to be sync
        $company->addUsersWorkingIn($this);
    }

    public function setCompany(array $company)
    {
        $result = [];

        foreach ($company as $value){

            if(!in_array($value, $result)){
                $result[] = $value;
            }

        }

        $this->company = $result;
    }

    public function removeCompany(UserCompany $user_company)
    {
        if(!$this->company->contains($user_company))
            return;

        $this->company->removeElement($user_company);

        //not needed for persistance but help to be sync
        $user_company->setCompany(null);
    }

    /**
     * @return ArrayCollection|UserCompany[]
     */
    public function getCompany()
    {
        return $this->company;
    }

}