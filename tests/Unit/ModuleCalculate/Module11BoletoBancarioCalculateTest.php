<?php

namespace BoletoKit\Tests\Unit\ModuleCalculate;

use BoletoKit\ModuleCalculate\Module11BoletoBancarioCalculate;
use PHPUnit\Framework\TestCase;

class Module11BoletoBancarioCalculateTest extends TestCase
{
    public function test_calculate_module_11_boleto_bancario_for_digits()
    {
        $digits = '2609264400002000002547643928578012461618527';

        $resultMod11 = (new Module11BoletoBancarioCalculate())->calculate($digits);

        $this->assertEquals(9, $resultMod11);
    }

    public function test_calculate_module_11_boleto_bancario_returns_1_when_resto_is_0()
    {
        $digits = '01230067896';

        $resultMod11 = (new Module11BoletoBancarioCalculate())->calculate($digits);

        $this->assertEquals(1, $resultMod11);
    }

    public function test_calculate_module_11_boleto_bancario_returns_1_when_resto_is_1()
    {
        $digits = '2609264400000200042547643928578012461618527';

        $resultMod11 = (new Module11BoletoBancarioCalculate())->calculate($digits);

        $this->assertEquals(1, $resultMod11);
    }

    public function test_calculate_module_11_boleto_bancario_returns_1_when_resto_is_10()
    {
        $digits = '9880000000182361207094244618305890485822017';

        $resultMod11 = (new Module11BoletoBancarioCalculate())->calculate($digits);

        $this->assertEquals(1, $resultMod11);
    }
}
