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

        $data=model('maindata')->select();
        return $this->fetch('',[
               'data'=>$data
        ]);
    }
    public function pay(){
        return $this->fetch();
    }
}