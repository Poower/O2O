<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/9/28
 * Time: 10:54
 */

namespace app\api\controller;


use think\Controller;
use think\Request;

class Image extends Controller
{
     public function upload(){
         $file=Request::instance()->file('file');
         //给定一个目录
         $info=$file->move('upload');
         if($info && $info->getPathname()){
             return show(1,'success','/'.$info->getPathname());
         }else{
             return show(0,'error',$file->getError());
         }
     }
     public function testimage(){
         $data=input('post.');
        // return $data;
         print_r($data);exit;
        // $date=input();
     }
}