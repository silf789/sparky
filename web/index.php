<?php

namespace app;

use app\classes\Router;
use app\model;
use app\controller;


include ('/../config/param.php');
include (DB . DS . 'db.php');



spl_autoload_register(function($classname){
    include_once ( __DIR__ . DS . '..' . DS . str_replace('\\', DS, $classname) . '.php');
});

$temp = new Router();
$temp->start();

