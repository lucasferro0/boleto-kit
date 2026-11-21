<?php

namespace BoletoKit\Parser\BoletoConvenio\LinhaDigitavel;

class LinhaDigitavelCampo1 extends LinhaDigitavelCampo
{
    public function isValid()
    {
        $methods = get_class_methods($this);

        foreach ($methods as $method) {
            if (in_array($method, ['isValid', '__construct'])) {
                continue;
            }

            $result = $this->{$method}();

            if ($result == '') {
                return false;
            }
        }

        return true;
    }
}