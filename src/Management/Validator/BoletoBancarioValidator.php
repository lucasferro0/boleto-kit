<?php

namespace BoletoKit\Management\Validator;

use BoletoKit\Parser\BoletoBancario\BoletoBancarioParser;

class BoletoBancarioValidator
{
    public function isValid(string $barcodeOrWritableLine)
    {
        return $this->isValidBarcode($barcodeOrWritableLine) || $this->isValidWritableLine($barcodeOrWritableLine);
    }

    public function isValidBarcode(string $barcode)
    {
        $boletoBancarioCodigoBarra = BoletoBancarioParser::parseCodigoBarra($barcode);

        return $boletoBancarioCodigoBarra->isValid();
    }

    public function isValidWritableLine(string $writableLine)
    {
        $boletoBancarioLinhaDigitavel = BoletoBancarioParser::parseLinhaDigitavel($writableLine);

        return $boletoBancarioLinhaDigitavel->isValid();
    }
}
