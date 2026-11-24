<?php

namespace BoletoKit\Parser\BoletoBancario;

use BoletoKit\Exceptions\BoletoKitInvalidBoletoBancarioBarcodeException;
use BoletoKit\ModuleCalculate\Module10Calculate;
use BoletoKit\ModuleCalculate\Module11BoletoBancarioCalculate;
use BoletoKit\Parser\BoletoBancario\CodigoBarra\CodigoBarraCampoLivre;
use BoletoKit\Parser\BoletoBancario\CodigoBarra\CodigoBarraTipoBancoCampoObrigatorio;
use BoletoKit\Parser\BoletoBancario\CodigoBarra\CodigoBarraTipoIspbCampoObrigatorio;

class BoletoBancarioCodigoBarra
{
    private string $codigoBarra;

    public function __construct(string $codigoBarra)
    {
        $this->codigoBarra = preg_replace('/[^0-9]/', '', $codigoBarra);
    }

    public function getCodigoBarra()
    {
        return $this->codigoBarra;
    }

    public function getCodigoBarraSemDigitoVerificador()
    {
        return substr($this->getCodigoBarra(), 0, 4) . substr($this->getCodigoBarra(), 5, 39);
    }

    public function isTipoBanco()
    {
        return substr($this->codigoBarra, 0, 3) != 988;
    }

    public function getCampoObrigatorio()
    {
        $isTipoBanco = $this->isTipoBanco();
        $campoObrigatorio = substr($this->codigoBarra, 0, 19);

        return $isTipoBanco
               ? new CodigoBarraTipoBancoCampoObrigatorio($campoObrigatorio)
               : new CodigoBarraTipoIspbCampoObrigatorio($campoObrigatorio);
    }

    public function getCampoLivre()
    {
        return new CodigoBarraCampoLivre(substr($this->codigoBarra, 19, 25));
    }

    public function isValid()
    {
        $codigoBarra = $this->getCodigoBarra();
        $campoObrigatório = $this->getCampoObrigatorio();

        if (strlen($codigoBarra) != 44) {
            return false;
        }

        if (! $campoObrigatório->isValid()) {
            return false;
        }

        if (! $this->getCampoLivre()->isValid()) {
            return false;
        }

        $codigoBarraSemDigitoVerificador = $this->getCodigoBarraSemDigitoVerificador();

        $digitoVerificadorEsperado = (new Module11BoletoBancarioCalculate())->calculate($codigoBarraSemDigitoVerificador);

        if ($campoObrigatório->getDigitoVerificador() != $digitoVerificadorEsperado) {
            return false;
        }

        return true;
    }

    public function toWritableLine()
    {
        if (! $this->isValid()) {
            throw new BoletoKitInvalidBoletoBancarioBarcodeException('Código de barra de boleto bancário inválido.');
        }

        $codigoBarra = $this->getCodigoBarra();
        $campoObrigatorio = $this->getCampoObrigatorio();

        if ($this->isTipoBanco()) {
            $codigoBanco = $campoObrigatorio->getCodigoBanco();
            $codigoMoeda = $campoObrigatorio->getCodigoMoeda();
            $pedacoCodigoBarra = substr($codigoBarra, 19, 5);
            $campo1SemDigitoVerificador = "{$codigoBanco}{$codigoMoeda}{$pedacoCodigoBarra}";
            $digitoVerificador = (new Module10Calculate())->calculate($campo1SemDigitoVerificador);
            $campo1 = "{$campo1SemDigitoVerificador}{$digitoVerificador}";

            $pedacoCodigoBarra = substr($codigoBarra, 24, 10);
            $campo2SemDigitoVerificador = $pedacoCodigoBarra;
            $digitoVerificador = (new Module10Calculate())->calculate($campo2SemDigitoVerificador);
            $campo2 = "{$campo2SemDigitoVerificador}{$digitoVerificador}";

            $pedacoCodigoBarra = substr($codigoBarra, 34, 10);
            $campo3SemDigitoVerificador = $pedacoCodigoBarra;
            $digitoVerificador = (new Module10Calculate())->calculate($campo3SemDigitoVerificador);
            $campo3 = "{$campo3SemDigitoVerificador}{$digitoVerificador}";

            $campo4 = $campoObrigatorio->getDigitoVerificador();

            $fatorVencimento = $campoObrigatorio->getFatorVencimento();
            $valorBoleto = $campoObrigatorio->getValorBoleto();
            $campo5 = "{$fatorVencimento}{$valorBoleto}";

            return "{$campo1}{$campo2}{$campo3}{$campo4}{$campo5}";
        }

        $codigoFebraban = $campoObrigatorio->getCodigoFebraban();
        $zero = $campoObrigatorio->getZero();
        $pedacoCodigoBarra = substr($codigoBarra, 19, 5);
        $campo1SemDigitoVerificador = "{$codigoFebraban}{$zero}{$pedacoCodigoBarra}";
        $digitoVerificador = (new Module10Calculate())->calculate($campo1SemDigitoVerificador);
        $campo1 = "{$campo1SemDigitoVerificador}{$digitoVerificador}";

        $pedacoCodigoBarra = substr($codigoBarra, 24, 10);
        $campo2SemDigitoVerificador = $pedacoCodigoBarra;
        $digitoVerificador = (new Module10Calculate())->calculate($campo2SemDigitoVerificador);
        $campo2 = "{$campo2SemDigitoVerificador}{$digitoVerificador}";

        $pedacoCodigoBarra = substr($codigoBarra, 34, 10);
        $campo3SemDigitoVerificador = $pedacoCodigoBarra;
        $digitoVerificador = (new Module10Calculate())->calculate($campo3SemDigitoVerificador);
        $campo3 = "{$campo3SemDigitoVerificador}{$digitoVerificador}";

        $campo4 = $campoObrigatorio->getDigitoVerificador();

        $zeros = $campoObrigatorio->getZeros();

        $campo5 = $campoObrigatorio->getIspb();

        return "{$campo1}{$campo2}{$campo3}{$campo4}{$zeros}{$campo5}";
    }
}
