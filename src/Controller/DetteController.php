<?php

namespace App\Controller;

use App\Entity\Dette;
use App\Form\DetteType;
use App\Repository\DetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DetteController extends AbstractController
{
    #[Route('/dettes', name: 'dettes.index', methods: ['GET'])]
    public function index(Request $request, DetteRepository $detteRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 4);
        $count = 0;
        $maxPage = 0;
       $dettes = $detteRepository->paginatedettes($page, $limit);
        $count = $dettes->count();
        $maxPage = ceil($count / $limit);
        return $this->render('dette/index.html.twig', [
            'dettes' => $dettes,
            'currentPage' => $page,
            'maxPages' => $maxPage,
        ]);
    }

    #[Route('/dettes/store{id?}', name: 'dettes.store', methods: ['GET', 'POST'])]
    public function store(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dette = new Dette();
        $form = $this->createForm(DetteType::class, $dette);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dette->setMontantVerser(0);
            $entityManager->persist($dette);
            $entityManager->flush();
            return $this->redirectToRoute('dettes.index');
        }
        return $this->render('dette/form.html.twig', [
            'formDette' => $form->createView(),
        ]);
        
    }
}
