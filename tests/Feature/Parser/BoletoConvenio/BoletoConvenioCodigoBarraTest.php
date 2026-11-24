<?php

namespace BoletoKit\Tests\Feature\Parser\BoletoConvenio;

use BoletoKit\Parser\BoletoConvenio\BoletoConvenioCodigoBarra;
use PHPUnit\Framework\TestCase;

class BoletoConvenioCodigoBarraTest extends TestCase
{
    public function test_se_extrai_campo_obrigatorio_e_livre_corretamente()
    {
        $codigoBarraRaw = '84690000001244900820899999319301099453529299';

        $boletoConvenioCodigoBarra = new BoletoConvenioCodigoBarra($codigoBarraRaw);

        $campoObrigatorio = $boletoConvenioCodigoBarra->getCampoObrigatorio();
        $campoLivre = $boletoConvenioCodigoBarra->getCampoLivre();

        $this->assertEquals(substr($codigoBarraRaw, 0, 1), $campoObrigatorio->getIdentificacaoProduto());
        $this->assertEquals(substr($codigoBarraRaw, 1, 1), $campoObrigatorio->getIdentificacaoSegmento());
        $this->assertEquals(substr($codigoBarraRaw, 2, 1), $campoObrigatorio->getCodigoMoeda());
        $this->assertEquals(substr($codigoBarraRaw, 3, 1), $campoObrigatorio->getDigitoVerificador());
        $this->assertEquals(substr($codigoBarraRaw, 4, 11), $campoObrigatorio->getValorBoleto());

        $this->assertEquals(substr($codigoBarraRaw, 15, 29), $campoLivre);
    }
}
