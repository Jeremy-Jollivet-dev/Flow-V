<?php

namespace App\Controller;

use App\Entity\Parcours;
use App\Form\Parcours1Type;
use App\Repository\ParcoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TypeDePointsRepository;
use App\Entity\PointsMAP;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\PointsMAPRepository;
use App\Repository\RealiserRepository;
use App\Entity\Realiser;
use Symfony\Component\HttpFoundation\JsonResponse;



#[Route('/parcours')]
final class ParcoursController extends AbstractController
{   
    #[Route(name: 'app_parcours_index', methods: ['GET'])]
    public function index(ParcoursRepository $parcoursRepository, Security $security): Response
    {
        $user = $this->getUser();

            if ($security->isGranted('ROLE_ROUTE_CREATOR')) {
      
                $parcours = $parcoursRepository->findByUser($user);
            } else {
             
                $parcours = $parcoursRepository->findAll();
            }


        return $this->render('parcours/index.html.twig', [
            'parcours' => $parcours,
        ]);
    }

    #[Route('/new', name: 'app_parcours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, TypeDePointsRepository $typeDePointsRepo)
    {
        $parcours = new Parcours();

        // Set default values
        $parcours->setStatus(true); // Default status
        $parcours->setDateCreation(new \DateTime()); // Creation date
        $parcours->setDateModification(new \DateTime()); // Modification date
        $parcours->setUsers($this->getUser()); // Current user

        $form = $this->createForm(Parcours1Type::class, $parcours);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $data = $request->request->all();
            // Retrieve points data from hidden fields
            $startPointData = json_decode($data['parcours1']['start_point'], true);
            $endPointData = json_decode($data['parcours1']['end_point'], true);
            $intermediatePointsData = json_decode($data['parcours1']['intermediate_points'], true);
            

            // Persist `Parcours` first to assign an ID
            $em->persist($parcours);
            $em->flush();

            // Create and add start point if it exists
            if ($startPointData) {
                $startPoint = new PointsMAP();
                $startPoint->setLat($startPointData['lat']);
                $startPoint->setLon($startPointData['lon']);
                $startPoint->setTypeDePoints($typeDePointsRepo->findTypedepointByType($startPointData['type']));
                $startPoint->setDetails($startPointData['details']);
                $startPoint->setParcours($parcours);
                $em->persist($startPoint);
                $parcours->addPointsMAP($startPoint);
            }

            // Create and add end point if it exists
            if ($endPointData) {
                $endPoint = new PointsMAP();
                $endPoint->setLat($endPointData['lat']);
                $endPoint->setLon($endPointData['lon']);
                $endPoint->setTypeDePoints($typeDePointsRepo->findTypedepointByType($endPointData['type']));
                $endPoint->setDetails($endPointData['details']);
                $endPoint->setParcours($parcours);
                $em->persist($endPoint);
                $parcours->addPointsMAP($endPoint);
            }

            // Create and add each intermediate point
            foreach ($intermediatePointsData as $pointData) {
                $intermediatePoint = new PointsMAP();
                $intermediatePoint->setLat($pointData['lat']);
                $intermediatePoint->setLon($pointData['lon']);
                $intermediatePoint->setTypeDePoints($typeDePointsRepo->findTypedepointByType($pointData['type']));
                $intermediatePoint->setDetails($pointData['details']);
                $intermediatePoint->setParcours($parcours);
                $em->persist($intermediatePoint);
                $parcours->addPointsMAP($intermediatePoint);
            }

            // Final flush to save all changes in one operation
            $em->flush();

            return $this->redirectToRoute('app_parcours_index');
        }

        // Fetch all point types
        $typesDePoints = $typeDePointsRepo->findAll();

        return $this->render('parcours/new.html.twig', [
            'form' => $form->createView(),
            'typesDePoints' => $typesDePoints,
        ]);
    }


    #[Route('/{id}', name: 'app_parcours_show', methods: ['GET'])]
    public function show(Parcours $parcour, PointsMAPRepository $pointsMapRepo, Security $security, RealiserRepository $realiserrepo): Response
    {
        $user = $security->getUser();

        // Récupérer tous les parcours réalisés par l'utilisateur
        $besttime = $realiserrepo->findMeilleurTempsParParcours($parcour->getid());
        if ($user) {
            $realiser = $realiserrepo->findOngoingParcours($user, $parcour);
        }else{
            $realiser = null;
        }
        asort($besttime);
        //dd($besttime);
 
        // Vérifier si un parcours en cours existe
        

        return $this->render('parcours/show.html.twig', [
            'parcour' => $parcour,
            'pointsMAPs' => $pointsMapRepo->findByParcoursId($parcour->getId()),
            'parcoursEnCours' => $realiser !== null,
            'classement' => $besttime,
            'userConnected' => $user !== null,
        ]);
    }
    

    #[Route('/{id}/edit', name: 'app_parcours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parcours $parcour, EntityManagerInterface $entityManager, TypeDePointsRepository $typeDePointsRepo, PointsMAPRepository $pointsMapRepo): Response
    {
        $form = $this->createForm(Parcours1Type::class, $parcour);
        $form->handleRequest($request);
        $parcour->setDateModification(new \DateTime()); // Date de modification à maintenant
        $parcour->setUsers($this->getUser()); // Utilisateur courant
        // Récupérer les points associés au parcours
        $pointsData = $pointsMapRepo->findByParcoursId($parcour->getId());

    if ($form->isSubmitted() && $form->isValid()) {
        $data = $request->request->all();

        // Récupération des données des points à partir des champs cachés
        $startPointData = json_decode($data['parcours1']['start_point'], true);
        $endPointData = json_decode($data['parcours1']['end_point'], true);
        $intermediatePointsData = json_decode($data['parcours1']['intermediate_points'], true);

        foreach ($pointsData as $point) {
            $entityManager->remove($point);
            $entityManager->flush();
        }
        
        // Traitement du point de départ
        if ($startPointData) {
            $startPoint = new PointsMAP();
            $startPoint->setLat($startPointData['lat']);
            $startPoint->setLon($startPointData['lon']);
            if (isset($startPointData['type'])) {
                $startPoint->setTypeDePoints($typeDePointsRepo->findTypedepointByType($startPointData['type']));
            }
            $startPoint->setDetails($startPointData['details']);
            $startPoint->setParcours($parcour);
            $entityManager->persist($startPoint);
            $entityManager->flush();
            $parcour->addPointsMAP($startPoint);
        }
        // Traitement du point d'arrivée
        if ($endPointData) {
            $endPoint = new PointsMAP();
            $endPoint->setLat($endPointData['lat']);
            $endPoint->setLon($endPointData['lon']);
            if (isset($endPointData['type'])) {
                $endPoint->setTypeDePoints($typeDePointsRepo->findTypedepointByType($endPointData['type']));
            }
            $endPoint->setDetails($endPointData['details']);
            $endPoint->setParcours($parcour);
            $entityManager->persist($endPoint);
            $entityManager->flush();
            $parcour->addPointsMAP($endPoint);
        }
        // Traitement des points intermédiaires
        foreach ($intermediatePointsData as $pointData) {
            $intermediatePoint = new PointsMAP();
            $intermediatePoint->setLat($pointData['lat']);
            $intermediatePoint->setLon($pointData['lon']);
            if (isset($pointData['type'])) {
                $intermediatePoint->setTypeDePoints($typeDePointsRepo->findTypedepointByType($pointData['type']));
            }
            $intermediatePoint->setDetails($pointData['details']);
            $intermediatePoint->setParcours($parcour);
            $entityManager->persist($intermediatePoint);
            $entityManager->flush();
            $parcour->addPointsMAP($intermediatePoint);
            
        }

        $entityManager->persist($parcour);
        $entityManager->flush();

        return $this->redirectToRoute('app_parcours_index');
    }

        return $this->render('parcours/edit.html.twig', [
            'parcour' => $parcour,
            'form' => $form->createView(),
            'pointsMAPs' => $pointsData,
        ]);
    }

    #[Route('/{id}', name: 'app_parcours_delete', methods: ['POST'])]
    public function delete(Request $request, Parcours $parcour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parcour->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($parcour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_parcours_index', [], Response::HTTP_SEE_OTHER);
    }




    #[Route('/{id}/start', name: 'app_parcours_start', methods: ['POST'])]
    public function start(int $id ,Parcours $parcour, Security $security, EntityManagerInterface $entityManager, RealiserRepository $realiserRepo): JsonResponse
    {
        $user = $security->getUser();
    
        $existingRealiser = $realiserRepo->findOngoingParcours($user, $parcour);
    
        if ($existingRealiser) {
            return new JsonResponse(['message' => 'Parcours déjà en cours'], 400);
        }
    
        $realiser = new Realiser();
        $realiser->setUser($user);
        $realiser->setParcours($parcour);
        $realiser->setDateDebut(new \DateTime());
    
        $entityManager->persist($realiser);
        $entityManager->flush();
    
        return new JsonResponse([
            'message' => 'Parcours démarré',
            'dateDebut' => (new \DateTime())->format('Y-m-d H:i:s'),
        ]);
    }

    #[Route('/{id}/end', name: 'app_parcours_end', methods: ['POST'])]
    public function end(Parcours $parcour, Security $security, EntityManagerInterface $entityManager,RealiserRepository $realiserrepo): JsonResponse
    {
        $user = $security->getUser();
        if (!$user) {
            return new JsonResponse(['message' => 'Utilisateur non authentifié'], 401);
        }
        // Trouver le parcours en cours
        $realiser = $realiserrepo->findOngoingParcours($user, $parcour);

        if (!$realiser) {
            return new JsonResponse(['message' => 'Aucun parcours en cours trouvé'], 404);
        }

        $realiser->setDateFin(new \DateTime());
        $entityManager->flush();


        return new JsonResponse([
            'message' => 'Parcours terminé',
            'dateFin' => (new \DateTime())->format('Y-m-d H:i:s'),
        ]);

    }

}
