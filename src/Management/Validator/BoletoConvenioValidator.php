<?php

namespace BoletoKit\Management\Validator;

use BoletoKit\Parser\BoletoBancario\BoletoBancarioParser;
use BoletoKit\Parser\BoletoConvenio\BoletoConvenioParser;

class BoletoConvenioValidator
{
    public function isValidBarcode(string $barcode)
    {
        $boletoConvenioCodigoBarra = BoletoConvenioParser::parseCodigoBarra($barcode);
        $boletoBancarioCodigoBarra = BoletoBancarioParser::parseCodigoBarra($barcode);

        return $boletoConvenioCodigoBarra->isValid() && ! $boletoBancarioCodigoBarra->isValid();
    }

    public function isValidWritableLine(string $writableLine)
    {
        $boletoConvenioLinhaDigitavel = BoletoConvenioParser::parseLinhaDigitavel($writableLine);
        $boletoBancarioLinhaDigitavel = BoletoBancarioParser::parseLinhaDigitavel($writableLine);

        return $boletoConvenioLinhaDigitavel->isValid() && ! $boletoBancarioLinhaDigitavel->isValid();
    }
}
