<?php


namespace App\Test\Helper;


use App\Helper\EncodedLink;
use PHPUnit\Framework\TestCase;

class EncodedLinkTest extends TestCase
{
    public function testFazerEncodedLink()
    {
        $encode = new EncodedLink();
        $resposta = $encode->getEncodedLink(1000);
        self::assertEquals('kaa', $resposta);
        $resposta = $encode->getEncodedLink(100);
        self::assertEquals('ka', $resposta);
        $resposta = $encode->getEncodedLink(1);
        self::assertEquals('b', $resposta);
        $resposta = $encode->getEncodedLink(6300);
        self::assertEquals('gdaa', $resposta);
        $resposta = $encode->getEncodedLink(1001);
        self::assertEquals('kab', $resposta);
        $resposta = $encode->getEncodedLink(1009);
        self::assertEquals('kaj', $resposta);
        $resposta = $encode->getEncodedLink(1010);
        self::assertEquals('kk', $resposta);
    }
}