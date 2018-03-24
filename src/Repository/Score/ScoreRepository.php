<?php

namespace App\Repository\Score;

use App\Entity\Score\Score;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Score|null find($id, $lockMode = null, $lockVersion = null)
 * @method Score|null findOneBy(array $criteria, array $orderBy = null)
 * @method Score[]    findAll()
 * @method Score[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoreRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Score::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('s')
            ->where('s.something = :value')->setParameter('value', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @return \App\Entity\Score[]
     */
    public function findAllActiveOrderByRecentlyActive()
    {
        return $this->createQueryBuilder('score')
            ->where('score.isActive = :isActive')
            ->setParameter('isActive', true)
            ->leftJoin('score.comments', 'score_comment')
            ->orderBy('score_comment.createdAt', 'DESC')
            ->setMaxResults(30)
            ->getQuery()
            ->getResult();
    }

    public function findByTerm($term)
    {
        //$dql = 'SELECT score FROM App\Entity\Score score ORDER BY score.score DESC';

        //$query =  $this->getEntityManager()->createQuery($dql);


        //dump($query->getSQL());
        //dump($dql);

        return $this->createQueryBuilder('score')
            ->andWhere('score.name LIKE :searchTerm OR score.real_name LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$term.'%')
            ->getQuery()
            ->getResult();

    }


}
