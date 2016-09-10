<?php

namespace app\controller;

abstract class Controller
{
    public $defaultAction;
    public $currentName;
    public $title;
    public $description;
    public $keywords;

    abstract protected function setCurrentName();

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setDefaultAction()
    {
        $this->defaultAction = 'index';
    }

    public function show($part, array $vars=[])
    {
        $this->setCurrentName();
        foreach ($vars as $key=>$value)
        {
            $$key=$value;
        }
        require VP . $this->currentName. DS .$part.".php";
    }
    public function render($view, array $vars=[])
    {
        $param = [
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords
        ];
        $this->show('header',$param);
        $this->show($view, $vars);
        $this->show('footer');
    }
}