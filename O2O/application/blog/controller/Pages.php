<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/12/8
 * Time: 10:42
 */

namespace app\blog\controller;


use think\Controller;

class Pages extends Controller
{
    public function index($id){


        $data=model('Maindata')->get($id);
        return $this->fetch('',[
            'data'=>$data,
        ]);
    }
}