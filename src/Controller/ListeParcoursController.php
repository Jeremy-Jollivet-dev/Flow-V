<?php

// src/Controller/ListeParcoursController.php

namespace App\Controller;

use App\Repository\ParcoursRepository;
use App\Repository\DifficulteRepository;
use App\Repository\TypeDeParcoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;

class ListeParcoursController extends AbstractController
{
    #[Route('/', name: 'app_parcours')]
    public function index(
        Request $request,
        ParcoursRepository $parcoursRepository,
        Security $security,
        TypeDeParcoursRepository $typedeparcoursRepository,
        DifficulteRepository $difficultyRepository
    ): Response {
        $user = $security->getUser();
        
        // Récupérer les filtres de la requête (type et difficulté)
        $typeId = $request->query->get('type'); // Paramètre de filtre type
        $difficultyId = $request->query->get('difficulty'); // Paramètre de filtre difficulté

        // Déterminer la logique selon le rôle de l'utilisateur
        if ($user) {
            $roles = $user->getRoles();

            // Logique en fonction du rôle
            if (in_array('ROLE_ADMIN', $roles)) {
                // Si l'utilisateur est un administrateur, afficher tous les parcours
                $parcoursList = $parcoursRepository->findAllWithFilters($typeId, $difficultyId);
            } elseif (in_array('ROLE_ROUTE_CREATOR', $roles)) {
                // Si l'utilisateur est un créateur de parcours, afficher ses parcours privés + public + exclusifs
                $parcoursList = $parcoursRepository->findByUserWithFilters($user, $typeId, $difficultyId);
                $parcoursList = array_merge($parcoursList, $parcoursRepository->findPublicAndExclusiveWithFilters($typeId, $difficultyId));
            } elseif (in_array('ROLE_COMPETITOR', $roles)) {
                // Si l'utilisateur est compétiteur, afficher les parcours publics + exclusifs
                $parcoursList = $parcoursRepository->findPublicAndExclusiveWithFilters($typeId, $difficultyId);
            } elseif (in_array('ROLE_AMATEUR', $roles)) {
                // Si l'utilisateur est amateur, afficher uniquement les parcours publics
                $parcoursList = $parcoursRepository->findPublicWithFilters($typeId, $difficultyId);
            }
        } else {
            // Si l'utilisateur n'est pas connecté, afficher uniquement les parcours publics
            $parcoursList = $parcoursRepository->findPublicWithFilters($typeId, $difficultyId);
        }

        // Récupérer tous les types de parcours et les difficultés pour l'affichage dans les filtres
        $typeparcours = $typedeparcoursRepository->findAll();
        $difficulty = $difficultyRepository->findAll();

        return $this->render('parcours/parcours.twig', [
            'parcoursList' => $parcoursList,
            'user' => $user,
            'typedeparcours' => $typeparcours,
            'difficulty' => $difficulty,
            'selectedType' => $typeId,
            'selectedDifficulty' => $difficultyId,
        ]);
    }
}

