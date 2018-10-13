<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUserByToken(string $token, string $typeToken){
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT user
            FROM App\Entity\User user
            JOIN user.token token
            WHERE token.token = :token 
            AND token.type = :typeToken
            AND token.used = false'
        )
            ->setParameter('token', $token)
            ->setParameter('typeToken', $typeToken);
        return $query->getOneOrNullResult();
    }

    public function getUserByUsername(string $username)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT user
            FROM App\Entity\User user
            WHERE user.username = :username'
        )
            ->setParameter('username', $username);
        return $query->getOneOrNullResult();
    }
    public function getUserByEmail(string $email)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT user
            FROM App\Entity\User user
            WHERE user.email = :email'
        )
            ->setParameter('email', $email);
        return $query->getOneOrNullResult();
    }
//    /**
//     * @return User[] Returns an array of User objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
