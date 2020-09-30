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

    public function getDecodedLink(string $value): int
    {
        if (empty($value)) {
            throw new DomainException('Dado não pode ser vazio.');
        }
        $finalValue = $this->uncrypt($value);
        return intval($finalValue);
    }

    private function crypt(int $number): string
    {
        $arNumber = $this->splitNumber($number);
        $string = $this->generateCrypt($arNumber);
        return $string;

    }

    private function splitNumber(int $number): array
    {
        return str_split($number, 2);
    }

    private function generateCrypt(array $arData): string
    {
        $string = null;
        foreach ($arData as $v) {
            if($v === '00'){
                $string .= $this->arLetter[substr($v, 0, 1)];
                $string .= $this->arLetter[substr($v, 1, 2)];
            } else if ($v < 62 || $v !== '00') {
                $string .= $this->arLetter[$v];
            } else {
                $string .= $this->arLetter[substr($v, 0, 1)];
                $string .= $this->arLetter[substr($v, 1, 2)];
            }
        }
        return $string;
    }

    protected function uncrypt(string $string): int
    {
        $arString = $this->splitString($string);
        $number = $this->revertCrypt($arString);
        return $number;
    }

    private function splitString(string $string): array
    {
        return str_split($string);
    }

    private function revertCrypt(array $arData): int
    {
        $number = null;
        $arInvert = array_flip($this->arLetter);
        foreach ($arData as $v) {
            $number .= $arInvert[$v];
        }
        return $number;
    }
}