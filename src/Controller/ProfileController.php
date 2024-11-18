<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\RealiserRepository;


class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profil(Security $security, RealiserRepository $realiserrepo)
    {
        // Récupérer l'utilisateur authentifié
        $user = $security->getUser();

        // Récupérer les réalisations de l'utilisateur (parcours qu'il a terminés)
        $realiserEntries = $realiserrepo->findByUser($user->getId());

        // Tableau pour stocker les parcours et leurs temps
        $parcoursRealises = [];

        // Remplir le tableau avec le nom du parcours et le temps de réalisation
        foreach ($realiserEntries as $realiser) {
            $parcours = $realiser->getParcours();
            $tempsTotal = $realiserrepo->calculerTempsTotal($realiser->getId()); // Calculer le temps du parcours

            $parcoursRealises[] = [
                'parcours' => $parcours->getNomParcours(),
                'temps' => $tempsTotal,
            ];
        }
        //dd($parcoursRealises);
        // Passer les données à la vue
        return $this->render('profile/index.html.twig', [
            'parcoursRealises' => $parcoursRealises,
            'pseudo' => $user->getPseudo(),
        ]);
    }
}
