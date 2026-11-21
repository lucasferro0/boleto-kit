<?php

namespace BoletoKit;

use BoletoKit\Management\BoletoBancarioManager;
use BoletoKit\Management\BoletoConvenioManager;

class BoletoKit
{
    public static function boletoBancario()
    {
        return new BoletoBancarioManager();
    }

    public static function boletoConvenio()
    {
        return new BoletoConvenioManager();
    }

    public static function isValid(string $barcodeOrWritableLine)
    {
        return self::boletoBancario()->isValid($barcodeOrWritableLine) || self::boletoConvenio()->isValid($barcodeOrWritableLine);
    }

    public static function toBarcode(string $writableLine)
    {
        $boletoBancarioManager = self::boletoBancario();

        $isBoletoBancario = $boletoBancarioManager->isValidWritableLine($writableLine);

        if ($isBoletoBancario) {
            return $boletoBancarioManager->toBarcode($writableLine);
        }

        return self::boletoConvenio()->toBarcode($writableLine);
    }

    public static function toWritableLine(string $barcode)
    {
        $boletoBancarioManager = self::boletoBancario();

        $isBoletoBancario = $boletoBancarioManager->isValidBarcode($barcode);

        if ($isBoletoBancario) {
            return $boletoBancarioManager->toWritableLine($barcode);
        }

        return self::boletoConvenio()->toWritableLine($barcode);
    }
}