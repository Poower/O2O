<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/8
 * Time: 15:38
 */

namespace app\bis\controller;


use think\Controller;

class Imagetest extends Controller
{
    public function shenfenzheng(){
        return $this->fetch();
    }
    public function index(){
        return $this->fetch();
    }
    public function indexIframe(){
        return $this->fetch();
    }
}