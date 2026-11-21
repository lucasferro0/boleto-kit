<?php

namespace BoletoKit\Parser\BoletoBancario\LinhaDigitavel;

use BoletoKit\ModuleCalculate\Module10Calculate;

class LinhaDigitavelTipoIspbCampo1 extends LinhaDigitavelCampo
{
    public function getCodigoFebraban()
    {
        return substr($this->value, 0, 3);
    }

    public function getZero()
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

        if ($this->getCodigoFebraban() != 988) {
            return false;
        }

        if ($this->getZero() == 9) {
            return false;
        }

        $digitoVerificadorEsperado = (new Module10Calculate())->calculate(
            $this->getCodigoFebraban() . $this->getZero() . $this->getPedacoCodigoBarra()
        );

        if ($this->getDigitoVerificador() != $digitoVerificadorEsperado) {
            return false;
        }

        return true;
    }
}