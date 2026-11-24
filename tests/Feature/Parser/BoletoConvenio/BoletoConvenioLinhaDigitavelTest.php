<?php

namespace BoletoKit\Tests\Feature\Parser\BoletoConvenio;

use BoletoKit\Parser\BoletoConvenio\BoletoConvenioLinhaDigitavel;
use PHPUnit\Framework\TestCase;

class BoletoConvenioLinhaDigitavelTest extends TestCase
{
    public function test_se_extrai_campos_corretamente()
    {
        $linhaDigitavelFormatedRaw = '84690000001-5 24490082089-9 99993193010-4 99453529299-3';
        $linhaDigitavelRaw = preg_replace('/[^0-9]/', '', $linhaDigitavelFormatedRaw);

        $boletoConvenioLinhaDigitavel = new BoletoConvenioLinhaDigitavel($linhaDigitavelRaw);

        $this->assertEquals($linhaDigitavelRaw, $boletoConvenioLinhaDigitavel->getlinhaDigitavel());
        $this->assertEquals($linhaDigitavelFormatedRaw, $boletoConvenioLinhaDigitavel->getlinhaDigitavelFormatada());
    }
}
