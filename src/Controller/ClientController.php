<?php

namespace App\Controller;

use App\DTO\ClientSearchDTO;
use App\Entity\Client;
use App\Enum\StatutDette;
use App\Form\ClientSearchType;
use App\Form\ClientType;
use App\Form\SelectDetteType;
use App\Repository\ClientRepository;
use App\Repository\DetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClientController extends AbstractController
{
    #[Route('/clients', name: 'clients.index', methods: ['GET', 'POST'])]
    public function index(ClientRepository $clientRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 4);
        $count = 0;
        $maxPage = 0;
        $clientSearchDto = new ClientSearchDTO();
        $form = $this->createForm(ClientSearchType::class, $clientSearchDto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $clients = $clientRepository->searchClients($clientSearchDto, $page, $limit);
        } else {
            $clients = $clientRepository->paginateClients($page, $limit);
            $count = $clients->count();
        }
        $maxPage = ceil($count / $limit);
        return $this->render('client/index.html.twig', [
            'formClientSearch' => $form->createView(),
            'clients' => $clients,
            'currentPage' => $page,
            'maxPages' => $maxPage,
        ]);
    }
    

    #[Route('/clients/store', name: 'clients.store', methods: ['GET', 'POST'])]
    public function store(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator, UserPasswordHasherInterface $encoder): Response
    {
        $client = new Client();
        $errorsUser = [];
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        $toggleSwitch = $request->request->get('toggleSwitch');
        if ($form->isSubmitted()) {
            $errorsClient = $validator->validate($client);
            if ($toggleSwitch != null) {
                $user = $client->getUsers();
                if ($user->getPassword() != null) {
                    $hashedPassword = $encoder->hashPassword($user, $user->getPassword());
                    $user->setPassword($hashedPassword);
                }
                $errorsUser = $validator->validate($user);
            } else {
                $client->setUsers(null);
            }
            if (count($errorsClient) === 0 && count($errorsUser) === 0) {
                $entityManager->persist($client);
                $entityManager->flush();
                return $this->redirectToRoute('clients.index');
            } else {
                return $this->render('client/form.html.twig', [
                    'formClient' => $form->createView(),
                    'errorsUser' => $errorsUser,
                ]);
            }
            
        }
        return $this->render('client/form.html.twig', [
            'formClient' => $form->createView(),
        ]);
    }

    #[Route('/clients/dette/{id}', name: 'clients.dette', methods: ['GET', 'POST'])]
    public function dettesClient(int $id, Request $request, DetteRepository $detteRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 1);
        $maxPage = 0;
        $count = 0;
        $maxPage = 0;
        $form = $this->createForm(SelectDetteType::class);
        $form->handleRequest($request);
        $statut = $request->get('statut',StatutDette::NonSolde -> value);
        if ($request->query->has('select_dette')) {
            $statut = $request->query->all('select_dette')['montant'];
        }
        $dettes = $detteRepository->getDetteFiltre($statut, $id, $page, $limit);
        $count = $dettes->count();
        $maxPage = ceil($count / $limit);
        return $this->render('client/detteClient.html.twig', [
            'dettes' => $dettes,
            'currentPage' => $page,
            'maxPages' => $maxPage,
            'statut' => $statut,
            'formselectDette' => $form->createView(),
        ]);
    }

}
