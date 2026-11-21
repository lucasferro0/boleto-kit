<?php

namespace BoletoKit\Parser\BoletoConvenio;

use BoletoKit\Exceptions\BoletoKitInvalidBoletoConvenioWritableLineException;

class BoletoConvenioLinhaDigitavel
{
    private string $linhaDigitavel;

    public function __construct(string $linhaDigitavel)
    {
        $this->linhaDigitavel = preg_replace('/[^0-9]/', '', $linhaDigitavel);
    }

    public function getlinhaDigitavel()
    {
        return $this->linhaDigitavel;
    }

    public function getlinhaDigitavelFormatada()
    {
        $linhaDigitavel = $this->getlinhaDigitavel();

        $campo1 = substr($linhaDigitavel, 0, 11);
        $digitoVerificadorCampo1 = substr($linhaDigitavel, 11, 1);
        
        $campo2 = substr($linhaDigitavel, 12, 11);
        $digitoVerificadorCampo2 = substr($linhaDigitavel, 23, 1);
        
        $campo3 = substr($linhaDigitavel, 23, 11);
        $digitoVerificadorCampo3 = substr($linhaDigitavel, 34, 1);
        
        $campo4 = substr($linhaDigitavel, 34, 11);
        $digitoVerificadorCampo4 = substr($linhaDigitavel, 45, 1);

        return "{$campo1}-{$digitoVerificadorCampo1} {$campo2}-{$digitoVerificadorCampo2} {$campo3}-{$digitoVerificadorCampo3} {$campo4}-{$digitoVerificadorCampo4}";
    }

    public function isValid()
    {
        if (strlen($this->linhaDigitavel) != 48) {
            return false;
        }

        return true;
    }

    public function toBarcode()
    {
        if (! $this->isValid()) {
            throw new BoletoKitInvalidBoletoConvenioWritableLineException('Linha digitável de boleto de convênio inválida.');
        }

        $linhaDigitavel = $this->getlinhaDigitavel();

        $campo1 = substr($linhaDigitavel, 0, 11);
        $campo2 = substr($linhaDigitavel, 12, 11);
        $campo3 = substr($linhaDigitavel, 23, 11);
        $campo4 = substr($linhaDigitavel, 34, 11);

        return "{$campo1}{$campo2}{$campo3}{$campo4}";
    }
}