<?php

namespace App\Repository;

use App\Entity\Percussion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Percussion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Percussion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Percussion[]    findAll()
 * @method Percussion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PercussionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Percussion::class);
    }

    // /**
    //  * @return Percussion[] Returns an array of Percussion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Percussion
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
