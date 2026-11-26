<?php

namespace BoletoKit\Management\Validator;

use BoletoKit\Parser\BoletoBancario\BoletoBancarioParser;
use BoletoKit\Parser\BoletoConvenio\BoletoConvenioParser;

class BoletoBancarioValidator
{
    public function isValidBarcode(string $barcode)
    {
        $boletoBancarioCodigoBarra = BoletoBancarioParser::parseCodigoBarra($barcode);
        $boletoConvenioCodigoBarra = BoletoConvenioParser::parseCodigoBarra($barcode);

        return $boletoBancarioCodigoBarra->isValid() && ! $boletoConvenioCodigoBarra->isValid();
    }

    public function isValidWritableLine(string $writableLine)
    {
        $boletoBancarioLinhaDigitavel = BoletoBancarioParser::parseLinhaDigitavel($writableLine);
        $boletoConvenioLinhaDigitavel = BoletoConvenioParser::parseLinhaDigitavel($writableLine);

        return $boletoBancarioLinhaDigitavel->isValid() && ! $boletoConvenioLinhaDigitavel->isValid();
    }
}
