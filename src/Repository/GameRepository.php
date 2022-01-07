<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Game;
use App\Entity\Library;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /*public function findLastGames(int $limit = 10, bool $isAsc = true): array {
        $qb = $this->createQueryBuilder('game')
            ->select('game', 'genres', 'languages')
            ->join('game.genres', 'genres')
            ->join('game.languages', 'languages');

        if($isAsc) {
            $qb->orderBy('game.publishedAt', 'ASC');
        } else {
            $qb->orderBy('game.publishedAt', 'DESC');
        }

        return $qb->setMaxResults($limit)
        ->getQuery()
        ->getResult();
    }
    /**
     * @param int $limit
     * @param bool $isOrderedByName
     * @return array
     */
    public function findLimitedGames(string $orderField, string $order, int $limit = 10): array {
        return $this->createQueryBuilder('game')
            ->select('game')
            ->orderBy('game.'.$orderField, $order)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findMostPlayedGames(int $limit = 10): array {
        return $this->createQueryBuilder('game')
            ->select('game')
            ->join(Library::class, 'lib', Join::WITH, 'lib.game = game')
            ->groupBy('game')
            ->orderBy('count(game)', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneDetailedGame($slug): ?Game
    {
        return $this->createQueryBuilder('game')
            ->join('game.comments', 'comments')
            ->join('game.genres','genres')
            ->join('game.languages', 'languages')
            ->where('game.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }



    /**
     * Return all game name
     *
     * @param string $name
     * @return array
     */
    public function findAllNames(string $name): array
    {
        return $this->createQueryBuilder('game')
            ->select('game.name', 'game.id')
            ->where('game.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Game[] Returns an array of Game objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */




}
