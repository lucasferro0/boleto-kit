<?php

namespace BoletoKit\ModuleCalculate;

class Module11BoletoBancarioCalculate extends Module11Calculate
{
    /**
     * DV geral do boleto bancário (FEBRABAN): se 11 - resto for 0, 10 ou 11, o DV é 1.
     */
    public function calculate(string $value)
    {
        $resultMod11 = 11 - $this->calculateResto($value);

        if (in_array($resultMod11, [0, 10, 11])) {
            return 1;
        }

        return $resultMod11;
    }
}
