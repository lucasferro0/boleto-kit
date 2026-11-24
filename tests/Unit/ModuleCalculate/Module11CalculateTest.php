<?php

namespace BoletoKit\Tests\Unit\ModuleCalculate;

use BoletoKit\ModuleCalculate\Module11Calculate;
use PHPUnit\Framework\TestCase;

class Module11CalculateTest extends TestCase
{
    public function test_calculate_module_11_for_digits()
    {
        $digits = '01230067896';

        $resultMod11 = (new Module11Calculate())->calculate($digits);

        $this->assertEquals('0', $resultMod11);
    }
}
