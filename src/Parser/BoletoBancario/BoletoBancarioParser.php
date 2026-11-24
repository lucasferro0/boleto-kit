<?php

namespace BoletoKit\Parser\BoletoBancario;

class BoletoBancarioParser
{
    private function __construct()
    {
    }

    public static function parseCodigoBarra(string $codigoBarra)
    {
        return new BoletoBancarioCodigoBarra($codigoBarra);
    }

    public static function parseLinhaDigitavel(string $linhaDigitavel)
    {
        return new BoletoBancarioLinhaDigitavel($linhaDigitavel);
    }
}
