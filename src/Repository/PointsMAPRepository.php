<?php

namespace App\Repository;

use App\Entity\PointsMAP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PointsMAP>
 */
class PointsMAPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PointsMAP::class);
    }

    /**
     * @param int $parcoursId
     * @return PointsMAP[] Returns an array of PointsMAP objects
     */
    public function findByParcoursId($parcoursId)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.parcours = :parcours')
            ->setParameter('parcours', $parcoursId)
            ->getQuery()
            ->getResult();
    }
    //    /**
    //     * @return PointsMAP[] Returns an array of PointsMAP objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PointsMAP
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
