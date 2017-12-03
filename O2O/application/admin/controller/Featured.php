<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/8/7
 * Time: 10:05
 */

namespace app\admin\controller;



class Featured extends Base
{

   public function add(){
       if(request()->isPost()){
           //入库逻辑
           $data=input('post.');
           //数据校验  validate机制
           $id=model('Featured')->add($data);
           if($id){
               $this->success('添加成功');
           }else{
               $this->error('失败添加');
           }
       }else{
           //没有数据过来就直接显示
         //获取推荐位类别
         $types=config('featured.featured_type');
         return $this->fetch('',[
           'types'=>$types,
         ]);

       }
   }
    public function index(){

       $type=input('post.type',0,'intval');

      // print_r($type);exit;
       $featureds=model('Featured')->getByType($type);
       //print_r($featureds);exit;

       // print_r($type_id);exit;
        $types=config('featured.featured_type');
        return $this->fetch('',[
            'types'=>$types,
            'featureds'=>$featureds,
            'type'=>$type
        ]);
    }

    //写在base控制器里
//    public function status(){
//        $data=input('get.');
//        //数据校验 tp5的validate机制
//       $res=model('Featured')->save(['status'=>$data['status']],['id'=>$data['id']]);
//       if($res){
//           $this->success('更新成功');
//       }else{
//           $this->error('更新失败');
//       }
//    }
}