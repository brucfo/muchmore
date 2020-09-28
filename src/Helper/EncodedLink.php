<?php

namespace App\Helper;

use DomainException;

class EncodedLink
{
    private $arLetter = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
        't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O',
        'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    private $base = 0;
    private $length = 0;

    public function getEncodedLink(int $value): string
    {
        if (empty($value)) {
            throw new DomainException('Dado não pode ser vazio.');
        }
        $finalValue = $this->crypt($value);
        return $finalValue;
    }

    private function crypt(int $number): string
    {
        $arNumber  = $this->splitNumber($number);
        $string = $this->generateCrypt($arNumber);
        print_r($string);
        die();

    }

    private function splitNumber(int $number): array
    {
        return str_split($number, 2);
    }

    private function generateCrypt(array $arData): string
    {
        $string = null;
        foreach ($arData as $v) {
            if ($v < 62) {
                $string .= $this->arLetter[$v];
            } else {
                $string .= $this->arLetter[substr($v, 0, 1)];
                $string .= $this->arLetter[substr($v, 1, 2)];
            }
        }
        return $string;
    }
}