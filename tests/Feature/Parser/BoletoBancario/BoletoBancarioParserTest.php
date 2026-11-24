<?php

namespace BoletoKit\Tests\Feature\Parser\BoletoBancario;

use BoletoKit\Parser\BoletoBancario\BoletoBancarioCodigoBarra;
use BoletoKit\Parser\BoletoBancario\BoletoBancarioLinhaDigitavel;
use BoletoKit\Parser\BoletoBancario\BoletoBancarioParser;
use PHPUnit\Framework\TestCase;

class BoletoBancarioParserTest extends TestCase
{
    public function test_parse_codigo_barra()
    {
        $boletoBancarioCodigoBarra = BoletoBancarioParser::parseCodigoBarra('26099264400002000002547643928578012461618527');

        $this->assertInstanceOf(BoletoBancarioCodigoBarra::class, $boletoBancarioCodigoBarra);
    }

    public function test_parse_codigo_linha_digitavel()
    {
        $boletoBancarioLinhaDigitavel = BoletoBancarioParser::parseLinhaDigitavel('26092547644392857801224616185278926440000200000');

        $this->assertInstanceOf(BoletoBancarioLinhaDigitavel::class, $boletoBancarioLinhaDigitavel);
    }
}