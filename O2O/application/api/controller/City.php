<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/9/27
 * Time: 16:07
 */

namespace app\api\controller;


use think\Controller;

class City extends Controller
{
  public function getCitysByParentId(){
      $id=input('post.id');
      if(!$id){
          $this->error('ID不存在');
      }
      $city=model("city")->getByParentId($id);
      if($city){
          return show(1,'success',$city);
      }else{
          return show(0,'error');
      }
  }
}