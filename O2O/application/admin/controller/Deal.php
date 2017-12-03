<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/8/7
 * Time: 10:05
 */

namespace app\admin\controller;

use think\Controller;

class Deal extends Controller
{
   private $obj;
   public function _initialize(){
       $this->obj=model("Deal");
   }
   public function index(){
       $data=input('post.');
       $sdata=[];
       if(!empty($data['category_id'])){
           $sdata['category_id']=$data['category_id'];
       }
       if(!empty($data['city_id'])){
           $sdata['city_id']=$data['city_id'];
       }
       if(!empty($data['start_time'])&&!empty($data['end_time'])&&
       strtotime($data['end_time'])>strtotime($data['start_time'])){
           $sdata['create_time']=[
               ['gt',strtotime($data['start_time'])],
               ['lt',strtotime($data['end_time'])],
           ];

       }
       if(!empty($data['name'])){
           $sdata['name']=['like','%'.$data['name'].'%'];
       }
       $deals=$this->obj->getNormalDeals($sdata);

       //这两个数组键值是ID，键名是名称，一一对应再显示到前端
       $categoryArrs=$cityArrs=[];
       $categorys=model("Category")->getByParentId();
       foreach ($categorys as $category){
           $categoryArrs[$category->id]=$category->name;
       }
       $citys=model('City')->getNormalCitys();
       foreach ($citys as $city){
           $cityArrs[$city->id]=$city->name;
       }

       return $this->fetch('',[
           'categorys'=>$categorys,
           'citys'=>$citys,
           'deals'=>$deals,
           'category_id'=>empty($data['category_id'])?'':$data['category_id'],
           'city_id'=>empty($data['city_id'])?'':$data['city_id'],
           'name'=>empty($data['name'])?'':$data['name'],
           'start_time'=>empty($data['start_time'])?'':$data['start_time'],
           'end_time'=>empty($data['end_time'])?'':$data['end_time'],
           'cityArrs'=>$cityArrs,
           'categoryArrs'=>$categoryArrs
       ]);
   }
}