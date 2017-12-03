<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/8/7
 * Time: 10:05
 */

namespace app\admin\controller;

use think\Controller;

class Version extends Base
{
    /*
     * 作者自用：待改进问题与进度
     */
    public function index(){
        $controller=request()->controller();
      //  dump($controller);exit;
        $vers=model('version')->getByStatus();
        return $this->fetch('',[
                'vers'=>$vers,
                 'controller'=>$controller
            ]);
    }
    public function add(){
        return $this->fetch();
    }
    public function edit($id){
        $data=model('version')->get($id);
        //dump($data);exit;
        return $this->fetch('',[
            'data'=>$data
        ]);
    }
    public function save(){
     //   echo 11;
      if(input('get.id')){
          $id=input('get.id');
          $data=input('post.');
          $showtime=date("Y-m-d H:i:s");
          $data['comment']=$data['comment'].$showtime.'||';
          $res=model('version')->update($data,['id'=>$id]);
          if($res){
              $this->success('更新成功','version/index');
          }else{
              redirect('version/index');
          }
      }else{
        $data=input('post.');
        if($data){
            $res=model('version')->add($data);
         //   return $res;//$res为ID号
            if ($res){
                $this->success('成功记录，正在跳转','version/index');
            }
        }
      }

    }


}