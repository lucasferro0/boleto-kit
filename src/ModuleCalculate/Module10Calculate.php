<?php

namespace BoletoKit\ModuleCalculate;

class Module10Calculate
{
    public function calculate(string $value)
    {
        $sequence = [2, 1];

        $digits = [];
        $lenDigits = strlen($value);

        for ($i = 0; $i < $lenDigits; $i++) {
            $digits[] = $value[$i];
        }

        $digitsReverse = array_reverse($digits);

        $cont = 0;
        $lastPositionMod10 = 1;
        $results = '';
        foreach ($digitsReverse as $digit) {
            $sequenceDigit = $sequence[$cont];

            $results .= (string) ($sequenceDigit * $digit);

            if ($cont == $lastPositionMod10) {
                $cont = 0;

                continue;
            }

            $cont += 1;
        }

        $lenResults = strlen($results);
        $total = 0;
        for ($i = 0; $i < $lenResults; $i++) {
            $total += $results[$i];
        }

        $resto = $total % 10;

        if ($resto == 0) {
            return 0;
        }

        $resultMod10 = 10 - $resto;

        return $resultMod10;
    }
}
