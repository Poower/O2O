<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/24
 * Time: 14:12
 */

namespace app\index\controller;


use think\Controller;

class Base extends Controller
{
     public $city='';
     public $account='';

     public function _initialize(){
         //城市数据
        $citys=model('City')->getNormalCitys();

        $this->getCity($citys);
        //获取首页分类数据
         $cats=$this->getRecommendCats();
         //print_r($cats);exit;数组改装过，不要.name
        $this->assign('citys',$citys);//tp方法，赋值
         $this->assign('city',$this->city);
         $this->assign('cats',$cats);
         $this->assign('title','o2o团购网');
         $this->assign('controller',strtolower(request()->controller()));
         $this->assign('user',$this->getLoginUser());

     }
     public function getCity($citys){
         foreach ($citys as $city){
            $city=$city->toArray();
           // print_r($city);exit;
             if($city['is_default']==1){
                 $defaultuname=$city['uname'];
                 break;//终止for循环
             }
         }
         $defaultuname=$defaultuname ? $defaultuname : 'zhengzhou';
         if(session('cityuname','','o2o')&&!input('get.city')){
             $cityuname=session('cityuname','','o2o');
         }else{
            $cityuname=input('get.city',$defaultuname,'trim');
            session('cityuname',$cityuname,'o2o');
         }
         $this->city= model('City')->where(['uname'=>$cityuname])->find();
     }

    public function getLoginUser(){
        if(!$this->account){
            $this->account=session('o2o_user','','o2o');

        }
        return $this->account;
    }

   /*
   *获取首页推荐中的商品分类数据
   */
    public function getRecommendCats(){
         $parentIds=$sedcatArr=$recomCats=[];
         $cats=model('Category')->getNormalRecommendCategoryByParentId(0,5);
         foreach ($cats as $cat){
             $parentIds[]=$cat->id;
         }
         //获取二级分类的数据
       $sedCats=model('Category')->getNormalCategoryIdParentId($parentIds);
        foreach ($sedCats as $sedcat){
            $sedcatArr[$sedcat->parent_id][]=[
                'id'=>$sedcat->id,
                'name'=>$sedcat->name,
            ];
        }
        foreach ($cats as $cat){
            //recomCats 代表的是一级和二级数据， 第一参数是一级分类的那么，第二个参数是此一级分类下面的所有二级分类的数据
             $recomCats[$cat->id]=[$cat->name,empty($sedcatArr[$cat->id])?[]:$sedcatArr[$cat->id]];
        }
        return $recomCats;
    }

}