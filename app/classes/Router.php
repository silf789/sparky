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
    private $module;
    private $action;
    private $controller;
    public  $otherparams;

    public function setUriParts()
    {
        $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->uriParts =explode('/', trim($urlPath, '/'));
        return $this;
    }
    public function setModule()
    {
        $temp = array_shift($this->uriParts);
        if ( (in_array(ucfirst($temp),modules())) && ($temp != '') ) {
            $this->module = ucfirst($temp);
        } else {
            $this->module = MAIN;
        }
        return $this;
    }
    public function setAction()
    {
        $this->action = array_shift($this->uriParts);
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
            ->setModuleFile()
            ->setAction()
            ->setOtherParams();
    }

    public function start()
    {
        require CP.$this->controller.'.php';
        $controller='app\controller\\'.$this->controller;
        if ('' == $this->action OR null == $this->action)
        {
            $this->action='index';
        };
        if (is_callable(array($controller, $this->action)) == false) {
            die ('404 Not Found');
        };
        $route=new $controller($this->otherparams);
        $action=$this->action;
        $route->$action();
    }
} 