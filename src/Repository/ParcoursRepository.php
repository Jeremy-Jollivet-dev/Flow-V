<?php

namespace App\Repository;

use App\Entity\Parcours;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Parcours>
 */
class ParcoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parcours::class);
    }


    public function findByUser(Users $user)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.users = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function findPublicParcours()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.prive = 0')
            ->andWhere('p.exclusif = 0')
            ->getQuery()
            ->getResult();
    }
    public function findPublicAndExclusiveParcours()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.prive = 0 OR p.exclusif = 1')
            ->getQuery()
            ->getResult();
    }
    
    /* Requete avec les filtres */
    public function findAllWithFilters($typeId = null, $difficultyId = null)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        if ($typeId) {
            $queryBuilder->andWhere('p.typeDeParcours = :typeId')
                        ->setParameter('typeId', $typeId);
        }

        if ($difficultyId) {
            $queryBuilder->andWhere('p.difficulte = :difficultyId')
                        ->setParameter('difficultyId', $difficultyId);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function findPublicWithFilters($typeId = null, $difficultyId = null)
    {
        $queryBuilder = $this->createQueryBuilder('p')
                            ->andWhere('p.prive = 0')
                            ->andWhere('p.exclusif = 0'); // Seules les parcours publics

        if ($typeId) {
            $queryBuilder->andWhere('p.typeDeParcours = :typeId')
                        ->setParameter('typeId', $typeId);
        }

        if ($difficultyId) {
            $queryBuilder->andWhere('p.difficulte = :difficultyId')
                        ->setParameter('difficultyId', $difficultyId);
        }

        return $queryBuilder->getQuery()->getResult();
    }


    public function findByUserWithFilters(Users $user, $typeId = null, $difficultyId = null)
    {
        $queryBuilder = $this->createQueryBuilder('p')
                            ->andWhere('p.users = :user')
                            ->setParameter('user', $user);

        if ($typeId) {
            $queryBuilder->andWhere('p.typeDeParcours = :typeId')
                        ->setParameter('typeId', $typeId);
        }

        if ($difficultyId) {
            $queryBuilder->andWhere('p.difficulte = :difficultyId')
                        ->setParameter('difficultyId', $difficultyId);
        }

        return $queryBuilder->getQuery()->getResult();
    }


    public function findPublicAndExclusiveWithFilters($typeId = null, $difficultyId = null)
    {
        $queryBuilder = $this->createQueryBuilder('p')
                            ->andWhere('p.prive = 0 OR p.exclusif = 1'); // Public + Exclusif

        if ($typeId) {
            $queryBuilder->andWhere('p.typeDeParcours = :typeId')
                        ->setParameter('typeId', $typeId);
        }

        if ($difficultyId) {
            $queryBuilder->andWhere('p.difficulte = :difficultyId')
                        ->setParameter('difficultyId', $difficultyId);
        }

        return $queryBuilder->getQuery()->getResult();
}



}
