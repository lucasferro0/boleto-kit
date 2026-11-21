<?php

namespace BoletoKit\Parser\BoletoConvenio\CodigoBarra;

abstract class CodigoBarraCampo
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