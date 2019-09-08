<?php

namespace App\Repository\Admin;


use App\Entity\Admin\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function findAllUsersInBeierInc()
    {
        return $this->createQueryBuilder('company')
            ->leftJoin('company.usersWorkingIn', 'users')
            ->addSelect('users')
            ->getQuery()
            ->getResult();
    }
}