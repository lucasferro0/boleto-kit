<?php

namespace BoletoKit\Parser\BoletoConvenio;

class BoletoConvenioParser
{
    private function __construct()
    {
    }

    public static function parseCodigoBarra(string $codigoBarra)
    {
        return new BoletoConvenioCodigoBarra($codigoBarra);
    }

    public static function parseLinhaDigitavel(string $linhaDigitavel)
    {
        return new BoletoConvenioLinhaDigitavel($linhaDigitavel);
    }
}