<?php

namespace BoletoKit\Parser\BoletoBancario;

use BoletoKit\Exceptions\BoletoKitInvalidBoletoBancarioWritableLineException;
use BoletoKit\ModuleCalculate\Module11Calculate;
use BoletoKit\Parser\BoletoBancario\LinhaDigitavel\LinhaDigitavelTipoBancoCampo1;
use BoletoKit\Parser\BoletoBancario\LinhaDigitavel\LinhaDigitavelTipoBancoCampo2;
use BoletoKit\Parser\BoletoBancario\LinhaDigitavel\LinhaDigitavelTipoBancoCampo3;
use BoletoKit\Parser\BoletoBancario\LinhaDigitavel\LinhaDigitavelTipoBancoCampo4;
use BoletoKit\Parser\BoletoBancario\LinhaDigitavel\LinhaDigitavelTipoBancoCampo5;
use BoletoKit\Parser\BoletoBancario\LinhaDigitavel\LinhaDigitavelTipoIspbCampo1;
use BoletoKit\Parser\BoletoBancario\LinhaDigitavel\LinhaDigitavelTipoIspbCampo2;
use BoletoKit\Parser\BoletoBancario\LinhaDigitavel\LinhaDigitavelTipoIspbCampo3;
use BoletoKit\Parser\BoletoBancario\LinhaDigitavel\LinhaDigitavelTipoIspbCampo4;
use BoletoKit\Parser\BoletoBancario\LinhaDigitavel\LinhaDigitavelTipoIspbCampo5;

class BoletoBancarioLinhaDigitavel
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
        $campo2 = $this->getCampo2();
        $campo3 = $this->getCampo3();
        $campo4 = $this->getCampo4();
        $campo5 = $this->getCampo5();

        $campo1Formatado = substr($campo1, 0, 5) . '.' . substr($campo1, 5);
        $campo2Formatado = substr($campo2, 0, 5) . '.' . substr($campo2, 5);
        $campo3Formatado = substr($campo3, 0, 5) . '.' . substr($campo3, 5);
        $campo4Formatado = $campo4;
        $campo5Formatado = $campo5;

        return "{$campo1Formatado} {$campo2Formatado} {$campo3Formatado} {$campo4Formatado} {$campo5Formatado}";
    }

    public function isTipoBanco()
    {
        return substr($this->linhaDigitavel, 0, 3) != 988;
    }

    public function getCampo1()
    {
        $campo1 = substr($this->linhaDigitavel, 0, 10);

        return $this->isTipoBanco() 
               ? new LinhaDigitavelTipoBancoCampo1($campo1) 
               : new LinhaDigitavelTipoIspbCampo1($campo1);
    }

    public function getCampo2()
    {
        $campo2 = substr($this->linhaDigitavel, 10, 11);

        return $this->isTipoBanco() 
               ? new LinhaDigitavelTipoBancoCampo2($campo2) 
               : new LinhaDigitavelTipoIspbCampo2($campo2);
    }

    public function getCampo3()
    {
        $campo3 = substr($this->linhaDigitavel, 21, 11);

        return $this->isTipoBanco() 
               ? new LinhaDigitavelTipoBancoCampo3($campo3) 
               : new LinhaDigitavelTipoIspbCampo3($campo3);
    }

    public function getCampo4()
    {
        $campo4 = substr($this->linhaDigitavel, 32, 1);

        return $this->isTipoBanco() 
               ? new LinhaDigitavelTipoBancoCampo4($campo4) 
               : new LinhaDigitavelTipoIspbCampo4($campo4);
    }

    public function getCampo5()
    {
        $campo5 = substr($this->linhaDigitavel, 33, 14);

        return $this->isTipoBanco() 
               ? new LinhaDigitavelTipoBancoCampo5($campo5) 
               : new LinhaDigitavelTipoIspbCampo5($campo5);
    }

    public function isValid()
    {
        if (strlen($this->linhaDigitavel) != 47) {
            return false;
        }

        $campo1 = $this->getCampo1();
        $campo2 = $this->getCampo2();
        $campo3 = $this->getCampo3();
        $campo4 = $this->getCampo4();
        $campo5 = $this->getCampo5();

        if (! $campo1->isValid()) {
            return false;
        }

        if (! $campo2->isValid()) {
            return false;
        }

        if (! $campo3->isValid()) {
            return false;
        }

        if (! $campo4->isValid()) {
            return false;
        }

        if (! $campo5->isValid()) {
            return false;
        }

        $boletoBancarioCodigoBarra = $this->convertToBarcode();

        $codigoBarraSemDigitoVerificador = $boletoBancarioCodigoBarra->getCodigoBarraSemDigitoVerificador();
        $digitoVerificadorEsperado = (new Module11Calculate())->calculate($codigoBarraSemDigitoVerificador);

        if ($campo4 != ((string) $digitoVerificadorEsperado)) {
            return false;
        }

        return true;
    }

    public function toBarcode()
    {
        if (! $this->isValid()) {
            throw new BoletoKitInvalidBoletoBancarioWritableLineException('Linha digitável de boleto bancário inválida.');
        }

        return $this->convertToBarcode()->getCodigoBarra();
    }

    protected function convertToBarcode()
    {
        $campo1 = $this->getCampo1();
        $campo2 = $this->getCampo2();
        $campo3 = $this->getCampo3();
        $campo4 = $this->getCampo4();
        $campo5 = $this->getCampo5();

        if ($this->isTipoBanco()) {
            $codigoBanco = $campo1->getCodigoBanco();
            $codigoMoeda = $campo1->getCodigoMoeda();
            $fatorVencimento = $campo5->getFatorVencimento();
            $valorBoleto = $campo5->getValorBoleto();
            $pedacoCodigoBarra1 = $campo1->getPedacoCodigoBarra();
            $pedacoCodigoBarra2 = $campo2->getPedacoCodigoBarra();
            $pedacoCodigoBarra3 = $campo3->getPedacoCodigoBarra();

            $campoObrigatorio = "{$codigoBanco}{$codigoMoeda}{$campo4}{$fatorVencimento}{$valorBoleto}";
            $campoLivre = "{$pedacoCodigoBarra1}{$pedacoCodigoBarra2}{$pedacoCodigoBarra3}";

            return new BoletoBancarioCodigoBarra("{$campoObrigatorio}{$campoLivre}");
        }

        $codigoFebraban = $campo1->getCodigoFebraban();
        $zero = $campo1->getZero();
        $digitoVerificador = $campo4->getDigitoVerificador();
        $zeros = $campo5->getZeros();
        $ispb = $campo5->getIspb();
        $pedacoCodigoBarra1 = $campo1->getPedacoCodigoBarra();
        $pedacoCodigoBarra2 = $campo2->getPedacoCodigoBarra();
        $pedacoCodigoBarra3 = $campo3->getPedacoCodigoBarra();

        $campoObrigatorio = "{$codigoFebraban}{$zero}{$digitoVerificador}{$zeros}{$ispb}";
        $campoLivre = "{$pedacoCodigoBarra1}{$pedacoCodigoBarra2}{$pedacoCodigoBarra3}";

        return new BoletoBancarioCodigoBarra("{$campoObrigatorio}{$campoLivre}");
    }
}