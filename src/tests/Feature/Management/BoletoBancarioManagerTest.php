<?php

namespace BoletoKit\tests\Feature\Management;

use BoletoKit\Management\BoletoBancarioManager;
use PHPUnit\Framework\TestCase;

class BoletoBancarioManagerTest extends TestCase
{
    public function test_is_valid_method_works_with_boleto_bancario_barcode()
    {
        $boletoBancarioManager = new BoletoBancarioManager();

        $isValid = $boletoBancarioManager->isValid('00194265100004465437299301486079767976229215');

        $this->assertTrue($isValid);
    }

    public function test_is_valid_method_works_with_boleto_bancario_writable_line()
    {
        $boletoBancarioManager = new BoletoBancarioManager();

        $isValid = $boletoBancarioManager->isValid('00193999637326909562301217114162326440000200000');

        $this->assertTrue($isValid);
    }

    public function test_is_valid_method_works_with_boleto_bancario_writable_line_formated()
    {
        $boletoBancarioManager = new BoletoBancarioManager();

        $isValid = $boletoBancarioManager->isValid('26092.54764 43928.578012 24616.185278 9 26440000200000');

        $this->assertTrue($isValid);
    }

    public function test_to_barcode_method_works_with_boleto_bancario_writable_line()
    {
        $barcode = (new BoletoBancarioManager())->toBarcode('23797094274461830589804858220173726440000200000');

        $this->assertEquals('23797264400002000007094244618305890485822017', $barcode);
    }

    public function test_to_barcode_method_works_with_boleto_bancario_writable_line_formated()
    {
        $barcode = (new BoletoBancarioManager())->toBarcode('26092.54764 43928.578012 24616.185278 9 26440000200000');

        $this->assertEquals('26099264400002000002547643928578012461618527', $barcode);
    }

    public function test_to_writable_line_method_works_with_boleto_bancario_barcode()
    {
        $writableLine = (new BoletoBancarioManager())->toWritableLine('00194265100004465437299301486079767976229215');

        $this->assertEquals('00197299380148607976579762292153426510000446543', $writableLine);
    }
}