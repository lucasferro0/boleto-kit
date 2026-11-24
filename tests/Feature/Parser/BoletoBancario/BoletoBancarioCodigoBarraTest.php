<?php

namespace BoletoKit\Tests\Feature\Parser\BoletoBancario;

use BoletoKit\Parser\BoletoBancario\BoletoBancarioCodigoBarra;
use PHPUnit\Framework\TestCase;

class BoletoBancarioCodigoBarraTest extends TestCase
{
    public function test_se_extrai_campo_obrigatorio_e_livre_corretamente_tipo_banco()
    {
        $codigoBarraRaw = '23797264400002000007094244618305890485822017';

        $boletoBancarioCodigoBarra = new BoletoBancarioCodigoBarra($codigoBarraRaw);

        $campoObrigatorio = $boletoBancarioCodigoBarra->getCampoObrigatorio();

        $this->assertEquals(substr($codigoBarraRaw, 0, 19), $campoObrigatorio);
        $this->assertEquals(substr($codigoBarraRaw, 0, 3), $campoObrigatorio->getCodigoBanco());
        $this->assertEquals(substr($codigoBarraRaw, 3, 1), $campoObrigatorio->getCodigoMoeda());
        $this->assertEquals(substr($codigoBarraRaw, 4, 1), $campoObrigatorio->getDigitoVerificador());
        $this->assertEquals(substr($codigoBarraRaw, 5, 4), $campoObrigatorio->getFatorVencimento());
        $this->assertEquals(substr($codigoBarraRaw, 9, 10), $campoObrigatorio->getValorBoleto());

        $this->assertEquals(substr($codigoBarraRaw, 19, 25), $boletoBancarioCodigoBarra->getCampoLivre());
    }

    public function test_se_extrai_campo_obrigatorio_e_livre_corretamente_tipo_ispb()
    {
        $codigoBarraRaw = '98801000000182361207094244618305890485822017';

        $boletoBancarioCodigoBarra = new BoletoBancarioCodigoBarra($codigoBarraRaw);

        $campoObrigatorio = $boletoBancarioCodigoBarra->getCampoObrigatorio();

        $this->assertEquals(substr($codigoBarraRaw, 0, 19), $campoObrigatorio);
        $this->assertEquals(substr($codigoBarraRaw, 0, 3), $campoObrigatorio->getCodigoFebraban());
        $this->assertEquals(substr($codigoBarraRaw, 3, 1), $campoObrigatorio->getZero());
        $this->assertEquals(substr($codigoBarraRaw, 4, 1), $campoObrigatorio->getDigitoVerificador());
        $this->assertEquals(substr($codigoBarraRaw, 5, 4), $campoObrigatorio->getZeros());
        $this->assertEquals(substr($codigoBarraRaw, 9, 10), $campoObrigatorio->getIspb());

        $this->assertEquals(substr($codigoBarraRaw, 19, 25), $boletoBancarioCodigoBarra->getCampoLivre());
    }
}
