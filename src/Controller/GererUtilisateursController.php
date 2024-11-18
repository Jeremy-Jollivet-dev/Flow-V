<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\RolesRepository;

#[Route('/gerer/utilisateurs')]
final class GererUtilisateursController extends AbstractController
{
    #[Route(name: 'app_gerer_utilisateurs_index', methods: ['GET'])]
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('gerer_utilisateurs/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_gerer_utilisateurs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_gerer_utilisateurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gerer_utilisateurs/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gerer_utilisateurs_show', methods: ['GET'])]
    public function show(Users $user): Response
    {
        return $this->render('gerer_utilisateurs/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gerer_utilisateurs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Users $user, EntityManagerInterface $entityManager,RolesRepository $repositoryrole): Response
    {
        $form = $this->createForm(UsersType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            //dd($request->request->all()['users']);
            //$data=$request->request->all();

            $entityManager->flush();
    
            return $this->redirectToRoute('app_gerer_utilisateurs_index', [], Response::HTTP_SEE_OTHER);
        }

        
        

        return $this->render('gerer_utilisateurs/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gerer_utilisateurs_delete', methods: ['POST'])]
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_gerer_utilisateurs_index', [], Response::HTTP_SEE_OTHER);
    }
}
