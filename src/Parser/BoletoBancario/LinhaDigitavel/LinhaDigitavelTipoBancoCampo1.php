<?php

namespace BoletoKit\Parser\BoletoBancario\LinhaDigitavel;

use BoletoKit\ModuleCalculate\Module10Calculate;

class LinhaDigitavelTipoBancoCampo1 extends LinhaDigitavelCampo
{
    public function getCodigoBanco()
    {
        return substr($this->value, 0, 3);
    }

    public function getCodigoMoeda()
    {
        return substr($this->value, 3, 1);
    }

    public function getPedacoCodigoBarra()
    {
        return substr($this->value, 4, 5);
    }

    public function getDigitoVerificador()
    {
        return substr($this->value, 9, 1);
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

        $digitoVerificadorEsperado = (new Module10Calculate())->calculate(
            $this->getCodigoBanco() . $this->getCodigoMoeda() . $this->getPedacoCodigoBarra()
        );

        if ($this->getDigitoVerificador() != $digitoVerificadorEsperado) {
            return false;
        }

        return true;
    }
}