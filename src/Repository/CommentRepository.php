<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findLimitedComments(string $orderField, string $order, int $limit = 10): array {
        return $this->createQueryBuilder('comment')
            ->select('comment', 'game', 'account')
            ->join('comment.account', 'account')
            ->join('comment.game', 'game')
            ->orderBy('comment.'.$orderField, $order)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findOneGameLimitedComments(int $id, string $orderField, string $order, int $limit = 10): array {
        return $this->createQueryBuilder('comment')
            ->select('comment', 'game', 'account')
            ->join('comment.account', 'account')
            ->join('comment.game', 'game')
            ->where('game.id = :id')
            ->setParameter('id', $id)
            ->orderBy('comment.'.$orderField, $order)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Comments[] Returns an array of Comments objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comments
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
