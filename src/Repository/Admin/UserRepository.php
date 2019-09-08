<?php

namespace App\Repository\Admin;


use App\Entity\Admin\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneById(int $id): User
    {
        return $this->createQueryBuilder('users')
            ->andWhere('users.id = :id')
            ->setParameter('id', $id)
            ->leftJoin('users.company', 'company')
            ->addSelect('company')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findLastFifty()
    {
        return $this->createQueryBuilder('users')
            ->leftJoin('users.company', 'company')
            ->addSelect('company')
            ->getQuery()
            ->getResult();
    }

    public function findAllUsersAndCompanies()
    {
        return $this->createQueryBuilder('users')
            ->leftJoin('users.company', 'user_company')
            ->addSelect('user_company')
            ->leftJoin('user_company.company', 'company')
            ->addSelect('company')
            ->getQuery()
            ->getResult();
    }

    public function findAllUsersByCompanyName(string $company_name)
    {
        return $this->createQueryBuilder('users')
            ->leftJoin('users.company', 'user_company')
            ->addSelect('user_company')
            ->leftJoin('user_company.company', 'company')
            ->addSelect('company')
            ->andWhere('company.name LIKE :name')
            ->setParameter("name", '%'.$company_name.'%')
            ->getQuery()
            ->getResult();
    }

}