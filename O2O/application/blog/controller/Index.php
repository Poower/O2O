<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/12/8
 * Time: 10:41
 */

namespace app\blog\controller;


use think\Controller;

class Index extends Controller
{
    public function index(){
        //源地址http://www.yinwang.org/#

        $name=input('get.name');
        if(!$name){
          $data=model('maindata')->order('id','desc')->select();
//           halt($data);
//           memcacheSet('blogdata',json_encode($data,JSON_UNESCAPED_UNICODE),300);
//            $data=memcacheGet('blogdata');
//            $data=json_decode($data,true);

        }else{
            $data=model('maindata')->where('title',['like',$name.'%'],['like','%'.$name],['like','%'.$name.'%'],'or')->order('id','desc')->select();
           // halt($data);
        }
        return $this->fetch('',[
            'data'=>$data
        ]);
    }
    public function pay(){
        return $this->fetch();
    }

    public function search(){
            $data=input('post.');
            $data=$data['name'];
            $data='/?name='.$data;
            return $data;
    }
}