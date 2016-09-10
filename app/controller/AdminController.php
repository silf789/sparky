<?php
/**
 * Created by PhpStorm.
 * User: Павел
 * Date: 13.08.2016
 * Time: 18:30
 */

namespace app\controller;

class AdminController extends Controller
{
    public function setCurrentName()
    {
        $this->currentName = 'admin';
    }

    public function index()
    {
        $this->render('index');
    }
} 