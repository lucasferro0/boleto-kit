<?php

namespace BoletoKit\tests\Feature;

use BoletoKit\BoletoKit;
use BoletoKit\Management\BoletoBancarioManager;
use BoletoKit\Management\BoletoConvenioManager;
use PHPUnit\Framework\TestCase;

class BoletoKitTest extends TestCase
{
    public function test_returns_boleto_bancario_manager()
    {
        $boletoBancarioManager = BoletoKit::boletoBancario();

        $this->assertInstanceOf(BoletoBancarioManager::class, $boletoBancarioManager);
    }

    public function test_returns_boleto_convenio_manager()
    {
        $boletoConvenioManager = BoletoKit::boletoConvenio();

        $this->assertInstanceOf(BoletoConvenioManager::class, $boletoConvenioManager);
    }

    public function test_to_barcode_method_with_boleto_bancario_writable_line()
    {
        $barcode = BoletoKit::toBarcode('00199257004592877855923660852585426430000015000');

        $this->assertEquals('00194264300000150009257045928778552366085258', $barcode);
    }

    public function test_to_barcode_method_with_boleto_bancario_writable_line_formated()
    {
        $barcode = BoletoKit::toBarcode('00190.00009 01234.567004 00000.001180 7 55650000001050');

        $this->assertEquals('00197556500000010500000001234567000000000118', $barcode);
    }

    public function test_to_writable_line_method_with_boleto_bancario_barcode()
    {
        $writableLine = BoletoKit::toWritableLine('26099264400002000002547643928578012461618527');

        $this->assertEquals('26092547644392857801224616185278926440000200000', $writableLine);
    }

    public function test_is_valid_with_boleto_bancario_barcode()
    {
        $isValid = BoletoKit::isValid('26099264400002000002547643928578012461618527');

        $this->assertTrue($isValid);
    }

    public function test_is_valid_with_boleto_bancario_barcode_with_digito_verificador_errado()
    {
        $isValid = BoletoKit::isValid('26090264400002000002547643928578012461618527');

        $this->assertFalse($isValid);
    }

    public function test_is_valid_with_boleto_bancario_writable_line()
    {
        $isValid = BoletoKit::isValid('26092547644392857801224616185278926440000200000');

        $this->assertTrue($isValid);
    }

    public function test_is_valid_with_boleto_bancario_writable_line_formated()
    {
        $isValid = BoletoKit::isValid('26092.54764 43928.578012 24616.185278 9 26440000200000');

        $this->assertTrue($isValid);
    }

    public function test_is_valid_with_boleto_bancario_writable_line_with_digito_verificador_errado()
    {
        $isValid = BoletoKit::isValid('26092547644392857801224616185278126440000200000');

        $this->assertFalse($isValid);
    }
}