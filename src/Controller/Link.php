<?php


namespace App\Controller;


use App\Helper\EncodedLink;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Link extends AbstractController
{

    /**
     * @var EncodeLink
     */
    private $linkEncode;

    public function __construct(EncodedLink $linkEncode)
    {

        $this->linkEncode = $linkEncode;
    }

    /**
     * @Route("/links/gerar", methods={"POST"})
     */
    public function geraLink(Request $request): Response
    {
        try {
            $dataRequest = $request->getContent();
            $dataJson = json_decode($dataRequest);

            if (!isset($dataJson->link)) {
                return new Response('', Response::HTTP_BAD_REQUEST);
            }

            $data = $this->linkEncode->getEncodedLink(58102230);
            //$data = $this->linkEncode->crypt('');
            print_r($data);
            die();
        } catch (Exception $e) {
            return new JsonResponse(json_encode($error['data'] = $e->getMessage()), Response::HTTP_BAD_REQUEST);
        }
    }
}