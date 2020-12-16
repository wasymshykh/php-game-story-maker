<?php

spl_autoload_register('ldr');

function ldr($className)
{
    $path = DIR . "classes/";
    $ext = ".class.php";
    $full = $path . strtolower($className) . $ext;

    if (!file_exists($full)) {
        echo $full;
        die();
        return false;
    }

    include_once $full;
}
