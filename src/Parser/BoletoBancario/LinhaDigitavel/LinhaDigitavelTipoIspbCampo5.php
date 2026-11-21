<?php

namespace BoletoKit\Parser\BoletoBancario\LinhaDigitavel;

class LinhaDigitavelTipoIspbCampo5
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getIspb()
    {
        return $this->value;
    }

    public function isValid()
    {
        if ($this->getIspb() == str_repeat('0', 14)) {
            return false;
        }

        return true;
    }

    public function __toString()
    {
        return $this->value;
    }
}