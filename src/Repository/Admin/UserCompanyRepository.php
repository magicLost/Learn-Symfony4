<?php

namespace App\Repository\Admin;


use App\Entity\Admin\Company;
use App\Entity\Admin\UserCompany;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserCompanyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserCompany::class);
    }

    public function findUsersToForm()
    {
        return $this->createQueryBuilder('user_company')
            ->setMaxResults(50)
            ->leftJoin('user_company.user', 'user')
            ->addSelect('user')
            ->getQuery()
            ->getResult();
    }
}