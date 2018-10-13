<?php

namespace App\Repository;

use App\Entity\Quiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Quiz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quiz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quiz[]    findAll()
 * @method Quiz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    public function getQuizQuestion($quizId)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT *
            FROM App\Entity\Game g
            LEFT JOIN g.quiz q
            LEFT JOIN g.user u
            WHERE g.timeEnd is not NULL
            AND q.id = :quizId
            ORDER BY g.score DESC, DATE_DIFF(g.timeStart,g.timeEnd) ASC'
        )
            ->setParameter('quizId', $quizId)
            ->setMaxResults(3);
        return $query->getArrayResult();
    }
//    /**
//     * @return Quiz[] Returns an array of Quiz objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Quiz
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
