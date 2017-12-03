<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/19
 * Time: 14:01
 */

namespace app\admin\controller;


use think\Controller;
use app\app\model\News as newsmodel;

class Base extends Controller
{
    public function test(){
        $where=[];
        $newss=new newsmodel();
        $news=$newss->getNews($where);
        halt($news);
    }

  public function status(){
      $data=input('get.');
     // dump($data);exit;
      //数据校验 tp5的validate机制

      //简单验证
      if(empty($data)){
          $this->error('ID不合法');
      }
      if(!is_numeric($data['status'])){
          $this->error('状态参数不合法');
      }


       $model=request()->controller();//tp5自带的方法：获取控制器的方法
    // echo $model;exit;
      $res=model($model)->save(['status'=>$data['status']],['id'=>$data['id']]);
      if($res){
          $this->success('更新成功');
      }else{
          $this->error('更新失败');
      }
  }
}