<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function getQuizLeaders(int $quizId, int $limit)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT g.score,u.username
            FROM App\Entity\Game g
            LEFT JOIN g.quiz q
            LEFT JOIN g.user u
            WHERE g.timeEnd is not NULL
            AND q.id = :quizId
            ORDER BY g.score DESC, DATE_DIFF(g.timeStart,g.timeEnd) ASC'
        )
            ->setParameter('quizId', $quizId)
            ->setMaxResults($limit);
        return $query->getArrayResult();
    }

    public function getAllQuizLeaders(int $quizId)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT g.score,u.username, g.id as gameId, u.id as userId
            FROM App\Entity\Game g
            LEFT JOIN g.quiz q
            LEFT JOIN g.user u
            WHERE g.timeEnd is not NULL
            AND q.id = :quizId
            ORDER BY g.score DESC, DATE_DIFF(g.timeStart,g.timeEnd) ASC'
        )
            ->setParameter('quizId', $quizId);
        return $query->getArrayResult();
    }

    public function getGame(int $quizId, int $userId)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT g
            FROM App\Entity\Game g
            LEFT JOIN g.quiz q
            LEFT JOIN g.user u
            WHERE u.id = :userId
            AND q.id = :quizId'
        )
            ->setParameter('userId', $userId)
            ->setParameter('quizId', $quizId);
        return $query->getOneOrNullResult();
    }

    public function getCountGame(int $quizId)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT Count(g)
            FROM App\Entity\Game g
            LEFT JOIN g.quiz q
            WHERE g.timeEnd is not NULL
            AND q.id = :quizId'
        )
            ->setParameter('quizId', $quizId);
        return (int)$query->getOneOrNullResult()[1];
    }

//    /**
//     * @return Game[] Returns an array of Game objects
//     */
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

    /*
    public function findOneBySomeField($value): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
