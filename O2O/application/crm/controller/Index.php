<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/12/3
 * Time: 5:08
 */

namespace app\crm\controller;


use think\Controller;

class Index extends Controller
{
    public function index(){

        echo 111;
        return $this->fetch();

    }
    public function server(){
        dump($_SERVER['REQUEST_URI']);
    }

}