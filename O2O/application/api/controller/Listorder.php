<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/9/28
 * Time: 10:20
 */

namespace app\api\controller;


use think\Controller;


class Listorder extends Controller
{
    public function listorder($id, $listorder,$controller){
//          $data=input('post.');
//          dump($data);exit;
      //  $con=request()->controller();
        $res=model($controller)->update(['listorder'=>$listorder], ['id'=>$id]);
        if($res) {
            //这个HTTP_REFERER应该就是返回上一个页面，之前都超全局变量不是很了解，有空再细研究
            //    $this->result($_SERVER['HTTP_REFERER'], 1, 'success');//result方法为tp5自带的返回给JS识别的json数据
           // return[$_SERVER['HTTP_REFERER'], 1, 'success'];
            return show(1,'success',$_SERVER['HTTP_REFERER']);
        }else {
            //    $this->result($_SERVER['HTTP_REFERER'], 0, '更新失败');
           // return[$_SERVER['HTTP_REFERER'], 0, '更新失败'];
            return show(0,'error');
        }
    }
}