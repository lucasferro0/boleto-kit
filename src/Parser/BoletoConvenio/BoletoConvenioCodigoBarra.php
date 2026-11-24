<?php

namespace BoletoKit\Parser\BoletoConvenio;

use BoletoKit\Exceptions\BoletoKitInvalidBoletoConvenioBarcodeException;
use BoletoKit\ModuleCalculate\Module10Calculate;
use BoletoKit\ModuleCalculate\Module11Calculate;
use BoletoKit\Parser\BoletoConvenio\CodigoBarra\CodigoBarraCampoLivre;
use BoletoKit\Parser\BoletoConvenio\CodigoBarra\CodigoBarraCampoObrigatorio;

class BoletoConvenioCodigoBarra
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
        return substr($this->getCodigoBarra(), 0, 3) . substr($this->getCodigoBarra(), 4, 44);
    }

    public function getCampoObrigatorio()
    {
        $campoObrigatorio = substr($this->codigoBarra, 0, 15);

        return new CodigoBarraCampoObrigatorio($campoObrigatorio);
    }

    public function getCampoLivre()
    {
        return new CodigoBarraCampoLivre(substr($this->codigoBarra, 15, 29));
    }

    public function isValid()
    {
        if (strlen($this->codigoBarra) != 44) {
            return false;
        }

        $campoObrigatorio = $this->getCampoObrigatorio();

        if (! $campoObrigatorio->isValid()) {
            return false;
        }

        if (! $this->getCampoLivre()->isValid()) {
            return false;
        }

        $usaModulo10 = $campoObrigatorio->canUseModule10();
        $rawForModuleCalculate = $this->getCodigoBarraSemDigitoVerificador();

        if ($usaModulo10) {
            $digitoVerificadorEsperado = (new Module10Calculate())->calculate($rawForModuleCalculate);
        } else {
            $digitoVerificadorEsperado = (new Module11Calculate())->calculate($rawForModuleCalculate);
        }

        if ($campoObrigatorio->getDigitoVerificador() != $digitoVerificadorEsperado) {
            return false;
        }

        return true;
    }

    public function toWritableLine()
    {
        if (! $this->isValid()) {
            throw new BoletoKitInvalidBoletoConvenioBarcodeException('Código de barra de boleto de convênio inválido.');
        }

        $usaModulo10 = $this->getCampoObrigatorio()->canUseModule10();

        $codigoBarra = $this->getCodigoBarra();

        $campo1 = substr($codigoBarra, 0, 11);
        $campo2 = substr($codigoBarra, 11, 11);
        $campo3 = substr($codigoBarra, 22, 11);
        $campo4 = substr($codigoBarra, 33, 11);

        if ($usaModulo10) {
            $digitoVerificadorCampo1 = (new Module10Calculate())->calculate($campo1);
            $digitoVerificadorCampo2 = (new Module10Calculate())->calculate($campo2);
            $digitoVerificadorCampo3 = (new Module10Calculate())->calculate($campo3);
            $digitoVerificadorCampo4 = (new Module10Calculate())->calculate($campo4);

            return "{$campo1}{$digitoVerificadorCampo1}{$campo2}{$digitoVerificadorCampo2}{$campo3}{$digitoVerificadorCampo3}{$campo4}{$digitoVerificadorCampo4}";
        }

        $digitoVerificadorCampo1 = (new Module11Calculate())->calculate($campo1);
        $digitoVerificadorCampo2 = (new Module11Calculate())->calculate($campo2);
        $digitoVerificadorCampo3 = (new Module11Calculate())->calculate($campo3);
        $digitoVerificadorCampo4 = (new Module11Calculate())->calculate($campo4);

        return "{$campo1}{$digitoVerificadorCampo1}{$campo2}{$digitoVerificadorCampo2}{$campo3}{$digitoVerificadorCampo3}{$campo4}{$digitoVerificadorCampo4}";
    }
}
