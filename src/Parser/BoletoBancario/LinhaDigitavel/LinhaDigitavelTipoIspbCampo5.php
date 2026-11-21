<?php

namespace BoletoKit\Parser\BoletoBancario\LinhaDigitavel;

class LinhaDigitavelTipoIspbCampo5
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getZeros()
    {
        return substr($this->value, 0, 4);
    }

    public function getIspb()
    {
        return substr($this->value, 4, 10);
    }

    public function isValid()
    {
        if ($this->getIspb() == str_repeat('0', 10)) {
            return false;
        }

        if ($this->getZeros() != str_repeat('0', 4)) {
            return false;
        }

        return true;
    }

    public function __toString()
    {
        return $this->value;
    }
}