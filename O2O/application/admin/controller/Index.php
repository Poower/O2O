<?php
namespace app\admin\controller;
use think\Controller;
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/8/7
 * Time: 9:33
 */
class Index extends Controller
{
   public function index(){
       return $this->fetch();
   }
   public function welcome(){
       return $this->fetch();
   }
   public function map(){
    return \Map::staticimage('河南省郑州郑州大学地铁站');
   }
   public function  mail(){
      \phpmailer\Email::send('1731512162@qq.com',1,'wew');

   }
}