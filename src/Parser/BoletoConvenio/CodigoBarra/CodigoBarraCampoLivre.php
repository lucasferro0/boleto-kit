<?php

namespace BoletoKit\Parser\BoletoConvenio\CodigoBarra;

class CodigoBarraCampoLivre extends CodigoBarraCampo
{
    public function isValid()
    {
        if ($this->value == '') {
            return false;
        }

        return true;
    }
}