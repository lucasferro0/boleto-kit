<?php

namespace BoletoKit\tests\Feature\Management;

use BoletoKit\Management\BoletoBancarioManager;
use PHPUnit\Framework\TestCase;

class BoletoBancarioManagerTest extends TestCase
{
    public function test_is_valid_method_works_with_boleto_bancario_barcode_tipo_banco()
    {
        $boletoBancarioManager = new BoletoBancarioManager();

        $isValid = $boletoBancarioManager->isValid('00194265100004465437299301486079767976229215');

        $this->assertTrue($isValid);
    }

    public function test_is_valid_method_works_with_boleto_bancario_writable_line_tipo_banco()
    {
        $boletoBancarioManager = new BoletoBancarioManager();

        $isValid = $boletoBancarioManager->isValid('00193999637326909562301217114162326440000200000');

        $this->assertTrue($isValid);
    }

    public function test_is_valid_method_works_with_boleto_bancario_writable_line_formated_tipo_banco()
    {
        $boletoBancarioManager = new BoletoBancarioManager();

        $isValid = $boletoBancarioManager->isValid('26092.54764 43928.578012 24616.185278 9 26440000200000');

        $this->assertTrue($isValid);
    }

    public function test_to_barcode_method_works_with_boleto_bancario_writable_line_tipo_banco()
    {
        $barcode = (new BoletoBancarioManager())->toBarcode('23797094274461830589804858220173726440000200000');

        $this->assertEquals('23797264400002000007094244618305890485822017', $barcode);
    }

    public function test_to_barcode_method_works_with_boleto_bancario_writable_line_formated_tipo_banco()
    {
        $barcode = (new BoletoBancarioManager())->toBarcode('26092.54764 43928.578012 24616.185278 9 26440000200000');

        $this->assertEquals('26099264400002000002547643928578012461618527', $barcode);
    }

    public function test_to_writable_line_method_works_with_boleto_bancario_barcode_tipo_banco()
    {
        $writableLine = (new BoletoBancarioManager())->toWritableLine('00194265100004465437299301486079767976229215');

        $this->assertEquals('00197299380148607976579762292153426510000446543', $writableLine);
    }

    public function test_is_valid_method_works_with_boleto_bancario_barcode_tipo_ispb()
    {
        $boletoBancarioManager = new BoletoBancarioManager();

        $isValid = $boletoBancarioManager->isValid('98801000000182361207094244618305890485822017');

        $this->assertTrue($isValid);
    }

    public function test_is_valid_method_works_with_boleto_bancario_writable_line_tipo_ispb()
    {
        $boletoBancarioManager = new BoletoBancarioManager();

        $isValid = $boletoBancarioManager->isValid('98800000060114971860168524522114000000018236120');

        $this->assertTrue($isValid);
    }

    public function test_is_valid_method_works_with_boleto_bancario_writable_line_formated_tipo_ispb()
    {
        $boletoBancarioManager = new BoletoBancarioManager();

        $isValid = $boletoBancarioManager->isValid('98800.00006 01149.718601 68524.522114 0 00000018236120');

        $this->assertTrue($isValid);
    }

    public function test_to_barcode_method_works_with_boleto_bancario_writable_line_tipo_ispb()
    {
        $barcode = (new BoletoBancarioManager())->toBarcode('98800000060114971860168524522114000000018236120');

        $this->assertEquals('98800000000182361200000001149718606852452211', $barcode);
    }

    public function test_to_barcode_method_works_with_boleto_bancario_writable_line_formated_tipo_ispb()
    {
        $barcode = (new BoletoBancarioManager())->toBarcode('98800.00006 01149.718601 68524.522114 0 00000018236120');

        $this->assertEquals('98800000000182361200000001149718606852452211', $barcode);
    }

    public function test_to_writable_line_method_works_with_boleto_bancario_barcode_tipo_ispb()
    {
        $writableLine = (new BoletoBancarioManager())->toWritableLine('98800000000182361200000001149718606852452211');

        $this->assertEquals('98800000060114971860168524522114000000018236120', $writableLine);
    }
}
