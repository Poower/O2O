<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/11/14
 * Time: 17:59
 */

namespace app\app\controller;
use think\Controller;
class Admin extends Controller
{
  public function add(){
      if(request()->post()){
         // dump(input('post.'));//halt()
          $data=input('post.');

          //validate
          $validate=validate('AdminUser');
          if(!$validate->check($data)){
            $this->error($validate->getError());
          }
          $data['password']=md5($data['password'].'#@poower');//#@poower为加盐
          $data['status']=1;
          //   halt($data);  //断点

          //检测用户名是否存在于表格中，username为唯一索引，否则会报MySQL报错
          $usernamecheck=model('adminUser')->get(['username'=>$data['username']]);
          if($usernamecheck){
              $this->error('用户名重复');
          }

          try{
          $id=model('adminUser')->add($data);
          }catch (\Exception $e){
              $this->error($e->getMessage());
          }
          if($id){
              $this->success('插入成功');
          }else{
              $this->error('添加失败');
          }
             return $id;

          
      }else{
          return $this->fetch();
      }

  }
}