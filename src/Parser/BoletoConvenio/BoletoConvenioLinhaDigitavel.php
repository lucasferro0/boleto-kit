<?php

namespace BoletoKit\Parser\BoletoConvenio;

use BoletoKit\Exceptions\BoletoKitInvalidBoletoConvenioWritableLineException;
use BoletoKit\ModuleCalculate\Module10Calculate;
use BoletoKit\ModuleCalculate\Module11Calculate;
use BoletoKit\Parser\BoletoConvenio\LinhaDigitavel\LinhaDigitavelCampo1;
use BoletoKit\Parser\BoletoConvenio\LinhaDigitavel\LinhaDigitavelCampo2;
use BoletoKit\Parser\BoletoConvenio\LinhaDigitavel\LinhaDigitavelCampo3;
use BoletoKit\Parser\BoletoConvenio\LinhaDigitavel\LinhaDigitavelCampo4;
use BoletoKit\Parser\BoletoConvenio\LinhaDigitavel\LinhaDigitavelDigitoVerificadorCampo1;
use BoletoKit\Parser\BoletoConvenio\LinhaDigitavel\LinhaDigitavelDigitoVerificadorCampo2;
use BoletoKit\Parser\BoletoConvenio\LinhaDigitavel\LinhaDigitavelDigitoVerificadorCampo3;
use BoletoKit\Parser\BoletoConvenio\LinhaDigitavel\LinhaDigitavelDigitoVerificadorCampo4;

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
        $campo1 = $this->getCampo1();
        $digitoVerificadorCampo1 = $this->getDigitoVerificadorCampo1();

        $campo2 = $this->getCampo2();
        $digitoVerificadorCampo2 = $this->getDigitoVerificadorCampo2();

        $campo3 = $this->getCampo3();
        $digitoVerificadorCampo3 = $this->getDigitoVerificadorCampo3();

        $campo4 = $this->getCampo4();
        $digitoVerificadorCampo4 = $this->getDigitoVerificadorCampo4();

        return "{$campo1}-{$digitoVerificadorCampo1} {$campo2}-{$digitoVerificadorCampo2} {$campo3}-{$digitoVerificadorCampo3} {$campo4}-{$digitoVerificadorCampo4}";
    }

    public function getCampo1()
    {
        $campo1 = substr($this->linhaDigitavel, 0, 11);

        return new LinhaDigitavelCampo1($campo1);
    }

    public function getDigitoVerificadorCampo1()
    {
        $digitoVerificadorCampo1 = substr($this->linhaDigitavel, 11, 1);

        return new LinhaDigitavelDigitoVerificadorCampo1($digitoVerificadorCampo1);
    }

    public function getCampo2()
    {
        $campo2 = substr($this->linhaDigitavel, 12, 11);

        return new LinhaDigitavelCampo2($campo2);
    }

    public function getDigitoVerificadorCampo2()
    {
        $digitoVerificadorCampo2 = substr($this->linhaDigitavel, 23, 1);

        return new LinhaDigitavelDigitoVerificadorCampo2($digitoVerificadorCampo2);
    }

    public function getCampo3()
    {
        $campo3 = substr($this->linhaDigitavel, 24, 11);

        return new LinhaDigitavelCampo3($campo3);
    }

    public function getDigitoVerificadorCampo3()
    {
        $digitoVerificadorCampo3 = substr($this->linhaDigitavel, 35, 1);

        return new LinhaDigitavelDigitoVerificadorCampo3($digitoVerificadorCampo3);
    }

    public function getCampo4()
    {
        $campo4 = substr($this->linhaDigitavel, 36, 11);

        return new LinhaDigitavelCampo4($campo4);
    }

    public function getDigitoVerificadorCampo4()
    {
        $digitoVerificadorCampo4 = substr($this->linhaDigitavel, 47, 1);

        return new LinhaDigitavelDigitoVerificadorCampo4($digitoVerificadorCampo4);
    }

    public function isValid()
    {
        if (strlen($this->linhaDigitavel) != 48) {
            return false;
        }

        $campo1 = $this->getCampo1();
        $digitoVerificadorCampo1 = $this->getDigitoVerificadorCampo1();

        $campo2 = $this->getCampo2();
        $digitoVerificadorCampo2 = $this->getDigitoVerificadorCampo2();

        $campo3 = $this->getCampo3();
        $digitoVerificadorCampo3 = $this->getDigitoVerificadorCampo3();

        $campo4 = $this->getCampo4();
        $digitoVerificadorCampo4 = $this->getDigitoVerificadorCampo4();

        if (! $campo1->isValid()) {
            return false;
        }

        if (! $digitoVerificadorCampo1->isValid()) {
            return false;
        }

        if (! $campo2->isValid()) {
            return false;
        }

        if (! $digitoVerificadorCampo2->isValid()) {
            return false;
        }

        if (! $campo3->isValid()) {
            return false;
        }

        if (! $digitoVerificadorCampo3->isValid()) {
            return false;
        }

        if (! $campo4->isValid()) {
            return false;
        }

        if (! $digitoVerificadorCampo4->isValid()) {
            return false;
        }

        $usaModulo10 = $this->convertToBarcode()->getCampoObrigatorio()->canUseModule10();

        $moduleCalculate = $usaModulo10 ? new Module10Calculate() : new Module11Calculate();

        if ($digitoVerificadorCampo1 != ((string) $moduleCalculate->calculate((string) $campo1))) {
            return false;
        }

        if ($digitoVerificadorCampo2 != ((string) $moduleCalculate->calculate((string) $campo2))) {
            return false;
        }

        if ($digitoVerificadorCampo3 != ((string) $moduleCalculate->calculate((string) $campo3))) {
            return false;
        }

        if ($digitoVerificadorCampo4 != ((string) $moduleCalculate->calculate((string) $campo4))) {
            return false;
        }

        $boletoConvenioCodigoBarra = $this->convertToBarcode();

        if (! $boletoConvenioCodigoBarra->isValid()) {
            return false;
        }

        return true;
    }

    public function toBarcode()
    {
        if (! $this->isValid()) {
            throw new BoletoKitInvalidBoletoConvenioWritableLineException('Linha digitável de boleto de convênio inválida.');
        }

        return $this->convertToBarcode()->getCodigoBarra();
    }

    protected function convertToBarcode()
    {
        $campo1 = $this->getCampo1();
        $campo2 = $this->getCampo2();
        $campo3 = $this->getCampo3();
        $campo4 = $this->getCampo4();

        return new BoletoConvenioCodigoBarra("{$campo1}{$campo2}{$campo3}{$campo4}");
    }
}
