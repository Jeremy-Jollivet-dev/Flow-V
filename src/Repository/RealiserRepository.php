<?php

namespace App\Repository;

use App\Entity\Realiser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Users;
use App\Entity\Parcours;
use Doctrine\DBAL\Statement;

/**
 * @extends ServiceEntityRepository<Realiser>
 */
class RealiserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Realiser::class);
    }
    public function findOngoingParcours(Users $user, Parcours $parcours): ?Realiser
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.user = :user')
            ->andWhere('r.parcours = :parcours')
            ->andWhere('r.dateFin IS NULL')
            ->setParameter('user', $user)
            ->setParameter('parcours', $parcours)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByParcours(int $parcoursId)
    {
        $qb = $this->createQueryBuilder('r') 
            ->innerJoin('r.parcours', 'p') 
            ->where('p.id = :parcoursId') 
            ->setParameter('parcoursId', $parcoursId);

        return $qb->getQuery()->getResult(); 
    }
    public function findMeilleurTempsParParcours(int $parcour): array
    {
        // Récupérer toutes les réalisations du parcours
        $realiserEntries = $this->findByParcours($parcour);

        // Tableau pour stocker les meilleurs temps par utilisateur
        $meilleursTemps = [];

        // Comparer les temps pour chaque utilisateur
        foreach ($realiserEntries as $realiser) {
            $user = $realiser->getUser();

            // Calculer le temps total du parcours
            $tempsTotal = $this->calculerTempsTotal($realiser->getId()); // Utiliser la méthode calculerTempsTotal

            // Si l'utilisateur n'a pas encore de temps enregistré, on l'ajoute
            if (!isset($meilleursTemps[$user->getId()]) || $tempsTotal < $meilleursTemps[$user->getId()]) {
                $meilleursTemps[$user->getPseudo()] = $tempsTotal; // Mettre à jour le meilleur temps
            }
        }

        return $meilleursTemps;
    }

    public function calculerTempsTotal(int $realiserId): float
    {
        $conn = $this->getEntityManager()->getConnection();
        
        // Utiliser executeQuery() pour exécuter la requête SQL
        $sql = 'SELECT CalculerTemps(:realiser_id) AS temps_total';
        $result = $conn->executeQuery($sql, ['realiser_id' => $realiserId])->fetchAssociative();
        
        // Vérifier et retourner le résultat
        if ($result === false || !isset($result['temps_total'])) {
            return 0.0;
        }

        return (float) $result['temps_total'];
    }

    public function findByUser(int $user)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Realiser[] Returns an array of Realiser objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Realiser
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
