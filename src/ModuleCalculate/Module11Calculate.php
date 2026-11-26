<?php

namespace BoletoKit\ModuleCalculate;

class Module11Calculate
{
    public function calculate(string $value)
    {
        $resto = $this->calculateResto($value);

        if (in_array($resto, [0, 1])) {
            return 0;
        }

        if ($resto == 10) {
            return 1;
        }

        $resultMod11 = 11 - $resto;

        return $resultMod11;
    }

    protected function calculateResto(string $value)
    {
        $sequence = [2, 3, 4, 5, 6, 7, 8, 9];

        $digits = [];
        $lenDigits = strlen($value);

        for ($i = 0; $i < $lenDigits; $i++) {
            $digits[] = $value[$i];
        }

        $digitsReverse = array_reverse($digits);

        $cont = 0;
        $lastPositionMod11 = 7;
        $total = 0;
        foreach ($digitsReverse as $digit) {
            $sequenceDigit = $sequence[$cont];

            $total += $sequenceDigit * $digit;

            if ($cont == $lastPositionMod11) {
                $cont = 0;

                continue;
            }

            $cont += 1;
        }

        return $total % 11;
    }
}
