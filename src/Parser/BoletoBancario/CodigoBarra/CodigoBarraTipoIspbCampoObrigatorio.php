<?php

namespace BoletoKit\Parser\BoletoBancario\CodigoBarra;

class CodigoBarraTipoIspbCampoObrigatorio extends CodigoBarraCampo
{
    public function getCodigoFebraban()
    {
        return substr($this->value, 0, 3);
    }

    public function getZero()
    {
        return substr($this->value, 3, 1);
    }

    public function getDigitoVerificador()
    {
        return substr($this->value, 4, 1);
    }

    public function getZeros()
    {
        return substr($this->value, 5, 4);
    }

    public function getIspb()
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

        if ($this->getZero() != 0) {
            return false;
        }

        if ($this->getZeros() != str_repeat('0', 4)) {
            return false;
        }

        return true;
    }
}