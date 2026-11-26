<?php

namespace BoletoKit\Management;

use BoletoKit\Management\Converter\BoletoConvenioConverter;
use BoletoKit\Management\Validator\BoletoConvenioValidator;

class BoletoConvenioManager
{
    private BoletoConvenioValidator $boletoConvenioValidator;

    private BoletoConvenioConverter $boletoConvenioConverter;

    public function __construct()
    {
        $this->boletoConvenioValidator = new BoletoConvenioValidator();

        $this->boletoConvenioConverter = new BoletoConvenioConverter();
    }

    public function isValid(string $barcodeOrWritableLine)
    {
        return $this->isValidBarcode($barcodeOrWritableLine) || $this->isValidWritableLine($barcodeOrWritableLine);
    }

    public function isValidBarcode(string $barcode)
    {
        return $this->boletoConvenioValidator->isValidBarcode($barcode);
    }

    public function isValidWritableLine(string $writableLine)
    {
        return $this->boletoConvenioValidator->isValidWritableLine($writableLine);
    }

    public function toBarcode(string $writableLine)
    {
        return $this->boletoConvenioConverter->toBarcode($writableLine);
    }

    public function toWritableLine(string $barcode)
    {
        return $this->boletoConvenioConverter->toWritableLine($barcode);
    }
}
