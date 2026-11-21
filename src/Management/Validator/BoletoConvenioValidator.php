<?php

namespace BoletoKit\Management\Validator;

use BoletoKit\Parser\BoletoConvenio\BoletoConvenioParser;

class BoletoConvenioValidator
{
    public function isValid(string $barcodeOrWritableLine)
    {
        return $this->isValidBarcode($barcodeOrWritableLine) || $this->isValidWritableLine($barcodeOrWritableLine);
    }

    public function isValidBarcode(string $barcode)
    {
        $boletoConvenioCodigoBarra = BoletoConvenioParser::parseCodigoBarra($barcode);

        return $boletoConvenioCodigoBarra->isValid();
    }

    public function isValidWritableLine(string $writableLine)
    {
        $boletoConvenioLinhaDigitavel = BoletoConvenioParser::parseLinhaDigitavel($writableLine);

        return $boletoConvenioLinhaDigitavel->isValid();
    }
}