<?php


namespace App\Controller;


use App\Entity\UrlShort;
use App\Helper\EncodedLink;
use App\Repository\UrlShortRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends AbstractController
{

    /**
     * @var EncodeLink
     */
    private $linkEncode;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UrlShortRepository
     */
    private $urlShortRepository;

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
     * @Route("/links", methods={"POST"})
     */
    public function geraLink(Request $request): Response
    {
        try {
            $dataRequest = $request->getContent();
            $dataJson = json_decode($dataRequest);
            $usuario = NULL;

            if (!isset($dataJson->link)) {
                return new Response('', Response::HTTP_BAD_REQUEST);
            }

            if (isset($dataJson->usuario)) {
                $usuario = $this->userRepository->find($dataJson->usuario);
            }

            $url = new UrlShort();
            $url
                ->setUrl($dataJson->link)
                ->setUser($usuario)
                ->setClicks(0)
                ->setCrypt('')
                ->setCreatedat(new DateTime("now"));

            $this->entityManager->persist($url);
            $this->entityManager->flush();


            $data = $this->linkEncode->getEncodedLink($url->getId());

            $url->setCrypt($data);

            $this->entityManager->flush();

            $short = 'http://' . $request->server->get('HTTP_HOST') . '/' . $data;
            $jresp['data'] = [$short];
            return new JsonResponse($jresp, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return new JsonResponse($error['data'] = $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/{link}", methods={"GET"})
     */
    public function accessLink(string $link, Request $request)
    {
        try {
            $idUrlShort = $this->linkEncode->getDecodedLink($link);
            $dataUrlShort = $this->urlShortRepository->find($idUrlShort);
            if(empty($dataUrlShort)) {
                return new JsonResponse('', Response::HTTP_BAD_REQUEST);
            }
            $short = 'http://' . $request->server->get('HTTP_HOST') . '/' . $dataUrlShort->getCrypt();
            $arReturn['url'] = [
                'original' => $dataUrlShort->getUrl(),
                'short' => $short
            ];

            $dataUrlShort->setClicks($dataUrlShort->getClicks()+1);
            $this->entityManager->flush();

            return new JsonResponse($arReturn);
        } catch (Exception $e) {
            return new JsonResponse($error['data'] = $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}