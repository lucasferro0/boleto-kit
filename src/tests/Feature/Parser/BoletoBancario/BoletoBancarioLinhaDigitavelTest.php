<?php

namespace BoletoKit\tests\Feature\Parser\BoletoBancario;

use BoletoKit\Parser\BoletoBancario\BoletoBancarioLinhaDigitavel;
use PHPUnit\Framework\TestCase;

class BoletoBancarioLinhaDigitavelTest extends TestCase
{
    public function test_se_extrai_campos_corretamente_tipo_banco()
    {
        $linhaDigitavelRaw = '23797094274461830589804858220173726440000200000';

        $boletoBancarioLinhaDigitavel = new BoletoBancarioLinhaDigitavel($linhaDigitavelRaw);

        $this->assertEquals(substr($linhaDigitavelRaw, 0, 10), $boletoBancarioLinhaDigitavel->getCampo1());
        $this->assertEquals(substr($linhaDigitavelRaw, 0, 3), $boletoBancarioLinhaDigitavel->getCampo1()->getCodigoBanco());
        $this->assertEquals(substr($linhaDigitavelRaw, 3, 1), $boletoBancarioLinhaDigitavel->getCampo1()->getCodigoMoeda());
        $this->assertEquals(substr($linhaDigitavelRaw, 4, 5), $boletoBancarioLinhaDigitavel->getCampo1()->getPedacoCodigoBarra());
        $this->assertEquals(substr($linhaDigitavelRaw, 9, 1), $boletoBancarioLinhaDigitavel->getCampo1()->getDigitoVerificador());


        $this->assertEquals(substr($linhaDigitavelRaw, 10, 11), $boletoBancarioLinhaDigitavel->getCampo2());
        $this->assertEquals(substr($linhaDigitavelRaw, 10, 10), $boletoBancarioLinhaDigitavel->getCampo2()->getPedacoCodigoBarra());
        $this->assertEquals(substr($linhaDigitavelRaw, 20, 1), $boletoBancarioLinhaDigitavel->getCampo2()->getDigitoVerificador());


        $this->assertEquals(substr($linhaDigitavelRaw, 21, 11), $boletoBancarioLinhaDigitavel->getCampo3());
        $this->assertEquals(substr($linhaDigitavelRaw, 21, 10), $boletoBancarioLinhaDigitavel->getCampo3()->getPedacoCodigoBarra());
        $this->assertEquals(substr($linhaDigitavelRaw, 31, 1), $boletoBancarioLinhaDigitavel->getCampo3()->getDigitoVerificador());

        $this->assertEquals(substr($linhaDigitavelRaw, 32, 1), $boletoBancarioLinhaDigitavel->getCampo4());
        $this->assertEquals(substr($linhaDigitavelRaw, 32, 1), $boletoBancarioLinhaDigitavel->getCampo4()->getDigitoVerificador());

        $this->assertEquals(substr($linhaDigitavelRaw, 33, 14), $boletoBancarioLinhaDigitavel->getCampo5());
        $this->assertEquals(substr($linhaDigitavelRaw, 33, 4), $boletoBancarioLinhaDigitavel->getCampo5()->getFatorVencimento());
        $this->assertEquals(substr($linhaDigitavelRaw, 37, 10), $boletoBancarioLinhaDigitavel->getCampo5()->getValorBoleto());
    }

    public function test_se_extrai_campos_corretamente_tipo_ispb()
    {
        $linhaDigitavelRaw = '98807094274461830589804858220173726440000200000';

        $boletoBancarioLinhaDigitavel = new BoletoBancarioLinhaDigitavel($linhaDigitavelRaw);

        $this->assertEquals(substr($linhaDigitavelRaw, 0, 10), $boletoBancarioLinhaDigitavel->getCampo1());
        $this->assertEquals(substr($linhaDigitavelRaw, 0, 3), $boletoBancarioLinhaDigitavel->getCampo1()->getCodigoFebraban());
        $this->assertEquals(substr($linhaDigitavelRaw, 3, 1), $boletoBancarioLinhaDigitavel->getCampo1()->getZero());
        $this->assertEquals(substr($linhaDigitavelRaw, 4, 5), $boletoBancarioLinhaDigitavel->getCampo1()->getPedacoCodigoBarra());
        $this->assertEquals(substr($linhaDigitavelRaw, 9, 1), $boletoBancarioLinhaDigitavel->getCampo1()->getDigitoVerificador());


        $this->assertEquals(substr($linhaDigitavelRaw, 10, 11), $boletoBancarioLinhaDigitavel->getCampo2());
        $this->assertEquals(substr($linhaDigitavelRaw, 10, 10), $boletoBancarioLinhaDigitavel->getCampo2()->getPedacoCodigoBarra());
        $this->assertEquals(substr($linhaDigitavelRaw, 20, 1), $boletoBancarioLinhaDigitavel->getCampo2()->getDigitoVerificador());


        $this->assertEquals(substr($linhaDigitavelRaw, 21, 11), $boletoBancarioLinhaDigitavel->getCampo3());
        $this->assertEquals(substr($linhaDigitavelRaw, 21, 10), $boletoBancarioLinhaDigitavel->getCampo3()->getPedacoCodigoBarra());
        $this->assertEquals(substr($linhaDigitavelRaw, 31, 1), $boletoBancarioLinhaDigitavel->getCampo3()->getDigitoVerificador());

        $this->assertEquals(substr($linhaDigitavelRaw, 32, 1), $boletoBancarioLinhaDigitavel->getCampo4());
        $this->assertEquals(substr($linhaDigitavelRaw, 32, 1), $boletoBancarioLinhaDigitavel->getCampo4()->getDigitoVerificador());

        $this->assertEquals(substr($linhaDigitavelRaw, 33, 14), $boletoBancarioLinhaDigitavel->getCampo5());
        $this->assertEquals(substr($linhaDigitavelRaw, 33, 14), $boletoBancarioLinhaDigitavel->getCampo5()->getIspb());
    }
}