<?php

namespace BoletoKit\Parser\BoletoBancario\CodigoBarra;

class CodigoBarraCampoLivre extends CodigoBarraCampo
{
    public function getCampoLivre()
    {
        return $this->value;
    }

    public function isValid()
    {
        if ($this->value == '') {
            return false;
        }

        return true;
    }
}