<?php

namespace BoletoKit\Management\Converter;

use BoletoKit\Parser\BoletoBancario\BoletoBancarioParser;

class BoletoBancarioConverter
{
    public function toBarcode(string $writableLine)
    {
        $boletoBancarioLinhaDigitavel = BoletoBancarioParser::parseLinhaDigitavel($writableLine);

        return $boletoBancarioLinhaDigitavel->toBarcode();
    }

    public function toWritableLine(string $barcode)
    {
        $boletoBancarioCodigoBarra = BoletoBancarioParser::parseCodigoBarra($barcode);

        return $boletoBancarioCodigoBarra->toWritableLine();
    }
}
