<?php

namespace BoletoKit\Parser\BoletoConvenio\CodigoBarra;

class CodigoBarraCampoObrigatorio extends CodigoBarraCampo
{
    public function getIdentificacaoProduto()
    {
        return substr($this->value, 0, 1);
    }

    public function getIdentificacaoSegmento()
    {
        return substr($this->value, 1, 1);
    }

    public function getCodigoMoeda()
    {
        return substr($this->value, 2, 1);
    }

    public function getDigitoVerificador()
    {
        return substr($this->value, 3, 1);
    }

    public function getValorBoleto()
    {
        return substr($this->value, 4, 11);
    }

    public function canUseModule10()
    {
        return in_array($this->getCodigoMoeda(), [6, 7]);
    }

    public function isValid()
    {
        $methods = get_class_methods($this);

        foreach ($methods as $method) {
            if (in_array($method, ['isValid', '__construct', 'canUseModule10'])) {
                continue;
            }

            $result = $this->{$method}();

            if ($result == '') {
                return false;
            }
        }

        if ($this->getIdentificacaoProduto() != 8) {
            return false;
        }

        if (! in_array($this->getIdentificacaoSegmento(), [1, 2, 3, 4, 5, 6, 7, 9])) {
            return false;
        }

        if (! in_array($this->getCodigoMoeda(), [6, 7, 8, 9])) {
            return false;
        }

        if (in_array($this->getCodigoMoeda(), [6, 8]) && $this->getValorBoleto() == str_repeat('0', 11)) {
            return false;
        }

        return true;
    }
}