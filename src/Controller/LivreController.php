<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/livre')]
final class LivreController extends AbstractController
{
    #[Route(name: 'app_livre_index', methods: ['GET'])]
    public function index(LivreRepository $livreRepository): Response
    {
        $livres = $livreRepository->findAll();
        return $this->render('livre/index.html.twig', [
            'livres' => $livres,
        ]);
    }
    
    #[Route('/afficher/{isbn}', name: 'app_livre_afficher', methods: ['GET'])]
    public function lelivre(LivreRepository $livreRepository, int $isbn = 0): Response
    {
        if (!$isbn)
            return $this->redirectToRoute('app_accueil');
        else
            $unLivre = $livreRepository->findOneBy(['isbn' => $isbn]);
        return $this->render('livre/show.html.twig', [
            'livre' => $unLivre,
        ]);
    }

    #[Route('/afficher/{isbn}/get-editeur', name: 'app_livre_editeur')]
    public function getEditeur(LivreRepository $livreRepository, int $isbn = 0): Response
    {
        $livre = $livreRepository->findOneBy(['isbn' => $isbn]);
        if (!$livre) {
            throw $this->createNotFoundException('Livre non trouvé');
        }
        $editeur = $livre->getEditeur();
        if (!$editeur) {
            throw $this->createNotFoundException('Éditeur non trouvé pour ce livre');
        }
        return new Response("Nom de l'éditeur : " . $editeur->getNomEditeur());
    }
    #[Route('/new', name: 'app_livre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('app_livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_livre_show', methods: ['GET'])]
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_livre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_livre_delete', methods: ['POST'])]
    public function delete(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $livre->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($livre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_livre_index', [], Response::HTTP_SEE_OTHER);
    }
}
