<?php
namespace app\app\controller;
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/8/7
 * Time: 9:33
 */
class Index extends Base
{
   public function index(){

      // halt(session('adminuser','','app'));
       return $this->fetch();
   }
   public function welcome(){
       return $this->fetch();
   }



}