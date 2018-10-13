<?php

namespace App\Repository;

use App\Entity\Answers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Answers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Answers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Answers[]    findAll()
 * @method Answers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Answers::class);
    }

    public function getCountAnswers(int $gameId)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT count(a)
            FROM App\Entity\Answers a
            LEFT JOIN a.game g
            WHERE g.id = :gameId'
        )
            ->setParameter('gameId', $gameId);
        $result = $query->getOneOrNullResult();
        return (int)$result[1];
    }
//    /**
//     * @return Answers[] Returns an array of Answers objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Answers
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
