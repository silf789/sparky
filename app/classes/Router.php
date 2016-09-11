<?php
/**
 * Created by PhpStorm.
 * User: Павел
 * Date: 13.08.2016
 * Time: 18:23
 */

namespace app\classes;

use app\controller;

class Router
{
    private $uriParts;
    private $module='';
    private $action='';
    private $controller;
    public  $otherparams;
    public $temp='';

    public function setUriParts()
    {
        $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->uriParts =explode('/', trim($urlPath, '/'));
        return $this;
    }
    public function setModule()
    {
        $temp = array_shift($this->uriParts);
        if ($temp == "" OR $temp == null) {
            $this->module = MAIN;
            $this->action = "index";
        } elseif (in_array(ucfirst($temp),modules()) OR ucfirst($temp) == MAIN) {
             $this->module = ucfirst($temp);
        } else {
            $this->module = MAIN;
            $this->action = $temp;
        }
        return $this;
    }
    public function setAction()
    {
        if ($this->action == '') {
            $this->action = array_shift($this->uriParts);
            if ($this->action == '' OR $this->action === NULL) {
                $this->action = "index";
            }
        }
        return $this;
    }
    public function setOtherParams()
    {
        $this->otherparams=[];
        while($this->uriParts != [])
        {
            $key=array_shift($this->uriParts);
            $this->otherparams[$key]=array_shift($this->uriParts);
        }
        return $this;
    }
    public function setModuleFile()
    {
        $this->controller=ucfirst ( $this->module."Controller");
        return $this;
    }
    public function __construct()
    {
        $this->setUriParts()
            ->setModule()
            ->setAction()
            ->setModuleFile()
            ->setOtherParams();
    }

    public function start()
    {
        if (file_exists(CP.$this->controller.'.php')) {
            require CP.$this->controller.'.php';
            $controller='app\controller\\'.$this->controller;
            if (!$this->exist($controller)) {
                $this->notfound();
            } else {
                $route=new $controller($this->otherparams);
                $action=$this->action;
                $route->$action();
            }
        } else {
            $this->notfound();
        }
    }

    public function exist($controller)
    {
        return is_callable(array($controller, $this->action));
    }

    public function notfound()
    {
        header('HTTP/1.x 404 Not Found');
        header("Status: 404 Not Found");
        include("notfound.php");
    }
} 