<?php

namespace BoletoKit\Parser\BoletoBancario\LinhaDigitavel;

class LinhaDigitavelTipoBancoCampo4 extends LinhaDigitavelCampo
{
    public function getDigitoVerificador()
    {
        return $this->value;
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

        return true;
    }
}
