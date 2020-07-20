<?php

namespace App\Repository;

use App\Entity\MovementImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MovementImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovementImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovementImage[]    findAll()
 * @method MovementImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovementImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovementImage::class);
    }

    // /**
    //  * @return MovementImage[] Returns an array of MovementImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MovementImage
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
