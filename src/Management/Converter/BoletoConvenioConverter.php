<?php

namespace BoletoKit\Management\Converter;

use BoletoKit\Parser\BoletoConvenio\BoletoConvenioParser;

class BoletoConvenioConverter
{
    public function toBarcode(string $writableLine)
    {
        $boletoConvenioLinhaDigitavel = BoletoConvenioParser::parseLinhaDigitavel($writableLine);

        return $boletoConvenioLinhaDigitavel->toBarcode();
    }

    public function toWritableLine(string $barcode)
    {
        $boletoConvenioCodigoBarra = BoletoConvenioParser::parseCodigoBarra($barcode);

        return $boletoConvenioCodigoBarra->toWritableLine();
    }
}