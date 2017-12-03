<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/9/27
 * Time: 16:07
 */

namespace app\api\controller;


use think\Controller;

class Category extends Controller
{
  public function getcategorysByParentId(){
      $id=input('post.id');
      if(!$id){
          $this->error('ID不存在');
      }
      $category=model("category")->getByParentId($id);
      if($category){
          return show(1,'success',$category);
      }else{
          return show(0,'error');
      }
  }
}