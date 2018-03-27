<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/12/26
 * Time: 13:31
 */

namespace app\blog\controller;




use think\Controller;

class Admin extends Controller
{
    public function index(){
        $cats=config('blog.cats');
        $tag=config('blog.tag');

        return $this->fetch('',[
            'cats'=>$cats,
            'tag'=>$tag,
        ]);
    }
    public function save(){
       $data=input('param.');
      // halt($data);


        if(!array_key_exists("content",$data)){
            $this->error('未输入内容');
        }

        if(array_key_exists("id",$data)){
            $res=model('Maindata')->save($data,['id'=>$data['id']]);
        }else{
            if(empty($data['title'])){
                $this->error('未输入标题');
            }
        $res=model('Maindata')->save($data);
        }

        if(!$res){
            $this->error('error');
        }else{
            $this->success('success','index/index');
        }


    }
    public function edit($id){
        $data=model('Maindata')->get($id);
        return $this->fetch('',[
            'data'=>$data,
        ]);
    }
}