<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/11/16
 * Time: 11:59
 */

namespace app\app\controller;


use think\Controller;

class Base extends Controller
{
    /**
     * 初始化方法
     */
   public function _initialize(){//tp5的方法执行其他方法必须执行这个方法，初始化方法
       $isLogin=$this->isLogin();
      // halt($session);
       if(!$isLogin){
           $this->error('请登录',('login/index'));
       }

   }
   public function isLogin(){
       $user=session('adminuser','','app');
       if($user && $user->id){
           return true;
       }
       return false;
   }

   /*
    * 获取分页内容
    */
   public function getPageAndSize(){

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

    public function delete(){
        $data=input('get.');
        // dump($data);exit;
        //数据校验 tp5的validate机制

        //简单验证
        if(empty($data)){
            $this->error('ID不合法');
        }



        $model=request()->controller();//tp5自带的方法：获取控制器的方法
        // echo $model;exit;
        $res=model($model)->save(['status'=>-1],['id'=>$data['id']]);
        if($res){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }
    }
}
