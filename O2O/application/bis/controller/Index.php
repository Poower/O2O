<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/9/27
 * Time: 14:29
 */

namespace app\bis\controller;


use think\Controller;

class Index extends Base
{
     public function index(){
         return $this->fetch();
     }
}