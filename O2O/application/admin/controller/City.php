<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/8/7
 * Time: 10:05
 */

namespace app\admin\controller;



class City extends Base
{
    public function index(){
        $data=input('get.');
        $pid=input('get.parent_id');
        if(empty($data)){

        $citys=model('city')->getByParentId();
        $citys_all=model('city')->getFirstAll();
        //select返回的是对象，我不想在模板中写逻辑，通过以下方法转变为数组
        //第二种转变为数组的方法是http://www.thinkphp.cn/topic/48131.html
        $list = collection($citys_all)->toArray();
     //   dump($list);exit;
        foreach ($list as $v){
          if($v['parent_id']!==0){
              //构建二维数组一一对应存入有父id的项
              $array['id']= $v['id'];
              $array['parent_id']= $v['parent_id'];
              $Array[]=$array;
              //这个数组存放有子类的分类id
              $Array_P[]=$v['parent_id'];
              //删除重复元素
              $Array_P=array_unique($Array_P);
              unset($arr);
          }
            }

        }else{
            $parent_id=$data['parent_id'];
            $citys=model('city')->getByParentId($parent_id);
            $Array_P=[];
        }

        return $this->fetch('',[
            'citys'=>$citys,
            'Array_P'=>$Array_P,
            'pid'=>$pid
        ]);
    }


    //写在base控制器里
//    public function status(){
//
//        $data=input('get.');
//        //安全措施：1、检测上个页面来源；2、把id和status动态更名让攻击者不能猜测（未实现）
//        $id=$data['id'];
//        $status=$data['sdadxwf'];
//        $res=model('city')->update(['status'=>$status],['id'=>$id]);
//        if($res){
//            //个人认为出现跳转等待页面的用户体验不佳，直接重定向
//            //$this->success('city/index');
//            $this->redirect('admin/city/index');
//        }else{
//            $this->error('更新失败');
//        }
//    }

    public function edit($id=0) {
        if(intval($id) < 1) {
            $this->error('参数不合法');
        }
        $city = model('city')->get($id);
        $citys = model('city')->getFirstALL();
        return $this->fetch('', [
            'citys'=> $citys,
            'city' => $city,
        ]);
    }
    public function add(){
        $pid=input('get.parent_id',0,'intval');
        $pname='一级分类';
        if($pid!=0) {
            $pname = model('city')->getByParentIdFIND($pid)->name;
        }
        $citys=model('city')->getFirstALL();

        //dump($citys);exit;
        return $this->fetch('',[
            'citys'=>$citys,
            'pid'=>$pid,
            'pname'=>$pname
        ]);
    }
    public function save(){
        if(!request()->isPost()) {
            $this->error('请求失败');
        }
        $data=input('post.');
        if(!empty($data['id'])) {
            return model('city')->update($data);
        }else{
            $res = model('city')->save($data);
            if($res) {
                $this->success('新增成功');
            }else {
                $this->error('新增失败');
            }
        }
    }
    public function listorder($id, $listorder){
        $res=model('city')->update(['listorder'=>$listorder], ['id'=>$id]);
        if($res) {
            //这个HTTP_REFERER应该就是返回上一个页面，之前都超全局变量不是很了解，有空再细研究
            $this->result($_SERVER['HTTP_REFERER'], 1, 'success');//result方法为tp5自带的返回给JS识别的json数据
        }else {
            $this->result($_SERVER['HTTP_REFERER'], 0, '更新失败');
        }
    }
}