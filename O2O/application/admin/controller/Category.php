<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/8/7
 * Time: 10:05
 */

namespace app\admin\controller;



class Category extends Base
{
    public function index(){
        $data=input('get.');
     //   var_dump($data);exit;
        $pid=input('get.parent_id');
       // var_dump($pid);
        if(empty($data)){

        $categorys=model('category')->getByParentId();
        $categorys_all=model('category')->getFirstAll();
        //select返回的是对象，我不想在模板中写逻辑，通过以下方法转变为数组
        //第二种转变为数组的方法是http://www.thinkphp.cn/topic/48131.html
        $list = collection($categorys_all)->toArray();
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
            $categorys=model('category')->getByParentId($parent_id);
            $Array_P=[];
        }

        return $this->fetch('',[
            'categorys'=>$categorys,
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
//        $res=model('category')->update(['status'=>$status],['id'=>$id]);
//        if($res){
//            //个人认为出现跳转等待页面的用户体验不佳，直接重定向
//            //$this->success('category/index');
//            $this->redirect('admin/category/index');
//        }else{
//            $this->error('更新失败');
//        }
//    }

    public function edit($id=0) {
        if(intval($id) < 1) {
            $this->error('参数不合法');
        }
//        $pid=input('get.parent_id',0);
//        $pname=model('category')->getByParentIdFIND($pid)->name;
        //和add页面逻辑还是稍有不同，故注释

        $category = model('category')->get($id);
        $categorys = model('category')->getFirstALL();
        return $this->fetch('', [
            'categorys'=> $categorys,
            'category' => $category,
//            'pid'=>$pid,
//            'pname'=>$pname
        ]);
    }
    public function add(){
        $pid=input('get.parent_id',0,'intval');
        $pname='一级分类';
        if($pid!=0) {
            $pname = model('category')->getByParentIdFIND($pid)->name;
        }
 //var_dump($pname);
        $categorys=model('category')->getFirstALL();

        //dump($categorys);exit;
        return $this->fetch('',[
            'categorys'=>$categorys,
            'pid'=>$pid,
            'pname'=>$pname
        ]);
    }
    public function save(){
        if(!request()->isPost()) {
            $this->error('请求失败');
        }
        $data=input('post.');
     //   var_dump($data);exit;  这犯过错：视图层忘加{}
        if(!empty($data['id'])) {
            return model('category')->update($data);
        }else{
            $res = model('category')->save($data);
            if($res) {
                $this->success('新增成功');
            }else {
                $this->error('新增失败');
            }
        }
    }

}