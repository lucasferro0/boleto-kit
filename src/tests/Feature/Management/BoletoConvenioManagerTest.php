<?php

namespace BoletoKit\tests\Feature\Management;

use BoletoKit\Management\BoletoConvenioManager;
use PHPUnit\Framework\TestCase;

class BoletoConvenioManagerTest extends TestCase
{
    public function test_is_valid_method_works_with_boleto_convenio_barcode()
    {
        $boletoConvenioManager = new BoletoConvenioManager();

        $isValid = $boletoConvenioManager->isValid('84690000001244900820899999319301099453529299');

        $this->assertTrue($isValid);
    }

    public function test_is_valid_method_works_with_boleto_convenio_writable_line()
    {
        $boletoConvenioManager = new BoletoConvenioManager();

        $isValid = $boletoConvenioManager->isValid('846900000015244900820899999931930104994535292993');

        $this->assertTrue($isValid);
    }

    public function test_is_valid_method_works_with_boleto_convenio_writable_line_formated()
    {
        $boletoConvenioManager = new BoletoConvenioManager();

        $isValid = $boletoConvenioManager->isValid('84690000001 5 24490082089 9 99993193010 4 99453529299 3');

        $this->assertTrue($isValid);
    }

    public function test_to_barcode_method_works_with_boleto_convenio_writable_line()
    {
        $barcode = (new BoletoConvenioManager())->toBarcode('846900000015244900820899999931930104994535292993');

        $this->assertEquals('84690000001244900820899999319301099453529299', $barcode);
    }

    public function test_to_barcode_method_works_with_boleto_convenio_writable_line_formated()
    {
        $barcode = (new BoletoConvenioManager())->toBarcode('84690000001 5 24490082089 9 99993193010 4 99453529299 3');

        $this->assertEquals('84690000001244900820899999319301099453529299', $barcode);
    }

    public function test_to_writable_line_method_works_with_boleto_convenio_barcode()
    {
        $writableLine = (new BoletoConvenioManager())->toWritableLine('84690000001244900820899999319301099453529299');

        $this->assertEquals('846900000015244900820899999931930104994535292993', $writableLine);
    }
}