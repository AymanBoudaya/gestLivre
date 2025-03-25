<?php
namespace App\Controller;

use App\Form\RechercheType;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RechercheController extends AbstractController
{
  #[Route('/recherche-livres', name: 'recherche_livres')]
  public function index(Request $request, LivreRepository $livreRepository): Response
  {
    $form = $this->createForm(RechercheType::class);
    $form->handleRequest($request);

    $livres = [];

    if ($form->isSubmitted() && $form->isValid()) {
      $data = $form->getData();

      $livres = $livreRepository->search(
        $data['titre'] ?? null,
        $data['editeur'] ?? null,
        $data['categorie'] ?? null
      );
    }

    return $this->render('recherche/index.html.twig', [
      'form' => $form->createView(),
      'livres' => $livres
    ]);
  }
}