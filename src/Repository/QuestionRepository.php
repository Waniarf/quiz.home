<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * @param int $quizId
     * @param int $num
     *
     * @return null
     */
    public function getQuestionByNum(int $quizId, int $num)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT questions
            FROM App\Entity\Question questions
            JOIN questions.quiz quiz
            WHERE quiz.id = :quizId'
        )
            ->setParameter('quizId', $quizId);
        $result = $query->getResult();
        if(count($result) <= $num)
            return null;
        return $result[$num];
    }

    /**
     * @param int $quizId
     *
     * @return int
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCountQuestionInQuiz(int $quizId): int
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT count(questions)
            FROM App\Entity\Question questions
            JOIN questions.quiz quiz
            WHERE quiz.id = :quizId'
        )
            ->setParameter('quizId', $quizId);
        $result = $query->getOneOrNullResult();
        return (int)$result[1];
    }

//    /**
//     * @return Question[] Returns an array of Question objects
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
    public function findOneBySomeField($value): ?Question
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
