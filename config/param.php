<?php
define('DS', DIRECTORY_SEPARATOR);
define('APPLICATION_DIR', __DIR__ . DS . ".." . DS);
define('APP', APPLICATION_DIR . "app" . DS);
define('CP', APP . "controller" . DS);
define('MP', APP . "model" . DS);
define('VP', APP . "view" . DS);
define('DB', __DIR__);
/**
 * Define head module for user-part of site
 */
define('MAIN', 'Main');
/**
 * all controllers (modules)
 * except Main
 */
function modules()
{
    return [
        'Admin'
    ];
}