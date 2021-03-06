<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/usuarios", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        $dataRequest = $request->getContent();
        $dataJson = json_decode($dataRequest);
        $user = new User();
        $user->setNome($dataJson->nome)
            ->setEmail($dataJson->email)
            ->setSenha(password_hash($dataJson->senha, PASSWORD_ARGON2ID));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $response = ['data' => "Usuário criado {$user->getEmail()} com sucesso."];

        return new JsonResponse($response, Response::HTTP_CREATED);
    }

    /**
     * @Route("/usuarios", methods={"PUT"})
     */
    public function atualiza(Request $request): Response
    {
        $dataRequest = $request->getContent();
        $dataJson = json_decode($dataRequest);
        $userSent = $this->userRepository->find($dataJson->id);

        if (empty($userSent)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        if(!isset($dataJson->nome) && !isset($dataJson->senha)) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        $dataJson = json_decode($dataRequest);
        $userSent->setNome($dataJson->nome);

        if(!empty($dataJson->senha)) {
            $userSent->setSenha(password_hash($dataJson->senha, PASSWORD_ARGON2ID));
        }

        $this->entityManager->flush();

        $response = ['data' => "Usuário {$userSent->getNome()} atualizado com sucesso."];
        return new JsonResponse($response);

    }

    /**
     * @Route("/usuarios/users", methods={"GET"})
     */
    public function buscarTodos(): Response
    {
        $userList = $this->userRepository->findAll();
        return new JsonResponse($userList);
    }

    /**
     * @Route("/usuarios/{id}", methods={"GET"})
     */
    public function buscarUm(int $id): Response
    {
        $user = $this->userRepository->find($id);

        $returnCode = empty($user) ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;
        return new JsonResponse($user, $returnCode);
    }
}
