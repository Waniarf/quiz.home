<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\QuestionOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuestionOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionOption[]    findAll()
 * @method QuestionOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionOptionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuestionOption::class);
    }

    /**
     * @param int $questionId
     *
     * @return array
     */
    public function getOptions(int $questionId): array
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT o
            FROM App\Entity\QuestionOption o
            LEFT JOIN o.question q
            WHERE q.id = :questionId'
        )
            ->setParameter('questionId', $questionId);
        return $query->getArrayResult();
    }

//    /**
//     * @return QuestionOption[] Returns an array of QuestionOption objects
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
    public function findOneBySomeField($value): ?QuestionOption
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
