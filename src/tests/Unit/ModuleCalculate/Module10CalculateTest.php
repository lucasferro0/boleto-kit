<?php

namespace BoletoKit\tests\Unit\ModuleCalculate;

use BoletoKit\ModuleCalculate\Module10Calculate;
use PHPUnit\Framework\TestCase;

class Module10CalculateTest extends TestCase
{
    public function test_calculate_module_10_for_digits()
    {
        $digits = '01230067896';

        $resultMod10 = (new Module10Calculate())->calculate($digits);

        $this->assertEquals('3', $resultMod10);
    }
}