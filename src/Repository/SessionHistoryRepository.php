<?php

namespace App\Repository;

use App\Entity\SessionHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SessionHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method SessionHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method SessionHistory[]    findAll()
 * @method SessionHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SessionHistory::class);
    }

    // /**
    //  * @return SessionHistory[] Returns an array of SessionHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SessionHistory
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
