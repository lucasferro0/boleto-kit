<?php

namespace BoletoKit\Parser\BoletoBancario\CodigoBarra;

class CodigoBarraTipoBancoCampoObrigatorio extends CodigoBarraCampo
{
    public function getCodigoBanco()
    {
        return substr($this->value, 0, 3);
    }

    public function getCodigoMoeda()
    {
        return substr($this->value, 3, 1);
    }

    public function getDigitoVerificador()
    {
        return substr($this->value, 4, 1);
    }

    public function getFatorVencimento()
    {
        return substr($this->value, 5, 4);
    }

    public function getValorBoleto()
    {
        return substr($this->value, 9, 10);
    }

    public function isValid()
    {
        $methods = get_class_methods($this);

        foreach ($methods as $method) {
            if (in_array($method, ['isValid', '__construct'])) {
                continue;
            }

            $result = $this->{$method}();

            if ($result == '') {
                return false;
            }
        }

        if ($this->getCodigoMoeda() != 9) {
            return false;
        }

        if ($this->getValorBoleto() == str_repeat('0', 10)) {
            return false;
        }

        return true;
    }
}
