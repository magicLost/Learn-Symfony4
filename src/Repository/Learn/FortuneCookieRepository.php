<?php

namespace App\Repository\Learn;

use App\Entity\Learn\Category;
use App\Entity\Learn\FortuneCookie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * FortuneCookieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FortuneCookieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FortuneCookie::class);
    }

    public function countNumberPrintedByCategory(Category $category)
    {

        return $this->createQueryBuilder('fc')
            ->andWhere('fc.category = :category')
            ->setParameter('category', $category)
            ->innerJoin('fc.category', 'category')
            ->select('SUM(fc.numberPrinted) as fortunesPrinted, 
                    AVG(fc.numberPrinted) as fortunesAverage, 
                    category.name')
            ->getQuery()
            ->getOneOrNullResult();
    }


}
