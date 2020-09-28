<?php


namespace App\Controller;


use App\Helper\EncodedLink;
use App\Repository\UrlShortRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UrlShortRepository
     */
    private $urlShortRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EncodedLink
     */
    private $linkEncode;

    public function __construct(
        EncodedLink $linkEncode,
        EntityManagerInterface $entityManager,
        UrlShortRepository $urlShortRepository,
        UserRepository $userRepository
    )
    {

        $this->linkEncode = $linkEncode;
        $this->entityManager = $entityManager;
        $this->urlShortRepository = $urlShortRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/stats/{link}", methods={"GET"})
     */
    public function stats(string $link, Request $request): Response
    {
        $idUrlShort = $this->linkEncode->getDecodedLink($link);
        $dataUrlShort = $this->urlShortRepository->find($idUrlShort);
        if(empty($dataUrlShort)) {
            return new JsonResponse('', Response::HTTP_BAD_REQUEST);
        }
        $short = 'http://' . $request->server->get('HTTP_HOST') . '/' . $dataUrlShort->getCrypt();
        $arReturn['url'] = [
            'original' => $dataUrlShort->getUrl(),
            'short' => $short,
            'createdAt' => $dataUrlShort->getCreatedat(),
            'stats' => ['clicks' => $dataUrlShort->getClicks()]
        ];

        return new JsonResponse($arReturn);
    }

    /**
     * @Route("/stats/user/{id}", methods={"GET"})
     */
    public function userStats(int $id)
    {
        $id = ($id === 0) ? NULL : $id;
        $shortUrl = $this->urlShortRepository->findBy(['user' => $id]);
        if(empty($shortUrl)) {
            return new JsonResponse('', Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($shortUrl);
    }
}