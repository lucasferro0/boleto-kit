<?php

namespace BoletoKit\Parser\BoletoBancario\LinhaDigitavel;

abstract class LinhaDigitavelCampo
{
    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }

    abstract public function isValid();
}
