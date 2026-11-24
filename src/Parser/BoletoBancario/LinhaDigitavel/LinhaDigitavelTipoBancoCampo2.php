<?php

namespace BoletoKit\Parser\BoletoBancario\LinhaDigitavel;

use BoletoKit\ModuleCalculate\Module10Calculate;

class LinhaDigitavelTipoBancoCampo2 extends LinhaDigitavelCampo
{
    public function getPedacoCodigoBarra()
    {
        return substr($this->value, 0, 10);
    }

    public function getDigitoVerificador()
    {
        return substr($this->value, 10, 1);
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

        $digitoVerificadorEsperado = (new Module10Calculate())->calculate($this->getPedacoCodigoBarra());

        if ($this->getDigitoVerificador() != $digitoVerificadorEsperado) {
            return false;
        }

        return true;
    }
}
