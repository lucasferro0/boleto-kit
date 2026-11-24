<?php

namespace BoletoKit\Parser\BoletoBancario\LinhaDigitavel;

class LinhaDigitavelTipoBancoCampo5 extends LinhaDigitavelCampo
{
    public function getFatorVencimento()
    {
        return substr($this->value, 0, 4);
    }

    public function getValorBoleto()
    {
        return substr($this->value, 4);
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

        if ($this->getFatorVencimento() == str_repeat('0', 4)) {
            return false;
        }

        if ($this->getValorBoleto() == str_repeat('0', 10)) {
            return false;
        }

        return true;
    }
}
