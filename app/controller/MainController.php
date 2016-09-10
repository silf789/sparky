<?php

namespace app\controller;

class MainController extends Controller
{
    public function setCurrentName()
    {
        $this->currentName = 'main';
    }
    public function index()
    {
        $this->render('index') ;
    }
}