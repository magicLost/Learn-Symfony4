<?php

namespace App\Repository\Score;


use App\Entity\Score\Score;
use App\Entity\Score\ScoreComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ScoreCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ScoreComment::class);
    }

    public function findAllRecentCommentsForScorer(Score $score)
    {
        return $this->createQueryBuilder('score_comment')
            ->andWhere('score_comment.score = :score')
            ->setParameter('score', $score)
            ->andWhere('score_comment.createdAt > :recentDate')
            ->setParameter('recentDate', new \DateTime('-3 months'))
            ->getQuery()
            ->getResult();
    }

    public function findAllCommentsJoinScoreName()
    {
        return $this->createQueryBuilder('sc')
            ->innerJoin('sc.score', 'score')
            ->select('sc.id as sc_id, sc.comment as comment, sc.createdAt as created_at, score.name')
            ->getQuery()
            ->getResult();
    }
}