<?php

namespace BoletoKit\Management;

use BoletoKit\Management\Converter\BoletoBancarioConverter;
use BoletoKit\Management\Validator\BoletoBancarioValidator;

class BoletoBancarioManager
{
    private BoletoBancarioValidator $boletoBancarioValidator;

    private BoletoBancarioConverter $boletoBancarioConverter;

    public function __construct()
    {
        $this->boletoBancarioValidator = new BoletoBancarioValidator();

        $this->boletoBancarioConverter = new BoletoBancarioConverter();
    }

    public function isValid(string $barcodeOrWritableLine)
    {
        return $this->boletoBancarioValidator->isValid($barcodeOrWritableLine);
    }

    public function isValidBarcode(string $barcode)
    {
        return $this->boletoBancarioValidator->isValidBarcode($barcode);
    }

    public function isValidWritableLine(string $writableLine)
    {
        return $this->boletoBancarioValidator->isValidWritableLine($writableLine);
    }

    public function toBarcode(string $writableLine)
    {
        return $this->boletoBancarioConverter->toBarcode($writableLine);
    }

    public function toWritableLine(string $barcode)
    {
        return $this->boletoBancarioConverter->toWritableLine($barcode);
    }
}
