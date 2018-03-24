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
            ->setMaxResults(50)
            ->leftJoin('users.company', 'company')
            ->addSelect('company')
            ->getQuery()
            ->getResult();
    }
}