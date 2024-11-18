<?php

namespace App\Repository;

use App\Entity\TypeDePoints;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeDePoints>
 */
class TypeDePointsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeDePoints::class);
    }


    public function findTypedepointByType(string $type): ?TypeDePoints
    {
        // Utilisation d'un query builder pour récupérer un type de point par type (par exemple "Départ", "Arrivée", etc.)
        return $this->createQueryBuilder('t')
            ->andWhere('t.libelleTypePoint = :libelleTypePoint')
            ->setParameter('libelleTypePoint', $type) // Correspondance exacte du nom du jeton
            ->getQuery()
            ->getOneOrNullResult();
    }


    //    /**
    //     * @return TypeDePoints[] Returns an array of TypeDePoints objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TypeDePoints
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
