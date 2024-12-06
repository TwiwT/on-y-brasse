<?php

namespace App\Repository;

use App\Entity\YeastStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<YeastStock>
 */
class YeastStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YeastStock::class);
    }

    //    /**
    //     * @return YeastStock[] Returns an array of YeastStock objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('y')
    //            ->andWhere('y.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('y.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?YeastStock
    //    {
    //        return $this->createQueryBuilder('y')
    //            ->andWhere('y.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
