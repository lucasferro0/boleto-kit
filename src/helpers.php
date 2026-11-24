<?php

if (! function_exists('debug')) {
    function debug($value)
    {
        var_dump($value);

        die;
    }
}

if (! function_exists('dump')) {
    function dump($value)
    {
        var_dump($value);
    }
}
