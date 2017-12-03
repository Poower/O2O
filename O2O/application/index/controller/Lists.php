<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/25
 * Time: 20:12
 */

namespace app\index\controller;


class Lists extends Base
{
    public function index(){
        $firstCatIds=[];
        $categoryParentId=0;
        $data=$orders=[];
        //首先需要一级栏目
        $categorys=model("Category")->getByParentId();
        foreach($categorys as $category){
            $firstCatIds[]=$category->id;
        }
        $id=input('id',0,'intval');//id=0 一级分类

        if(in_array($id,$firstCatIds)){//如果在这个数组里面说明是一级分类
            //php的数组是强大的
            $categoryParentId=$id;
            $data['category_id']=$id;
        }elseif ($id){//二级分类
            $category=model("Category")->get($id);
            if(!$category||$category->status !=1){
                $this->error('数据不合法');
            }
            $categoryParentId=$category->parent_id;
            $data['se_category_id']=$id;
        }

        //获取父类下的子分类
        if($categoryParentId!=0){

            $sedcategorys=model('Category')->getByParentId($categoryParentId);
          }else{
            $sedcategorys=[];//配合视图层显示，写有if codition，为空不显示
        }
        //     print_r($sedcategorys);exit;

        //排序数据获取的逻辑
        $order_sales=input('order_sales','');
        $order_price=input('order_price','');
        $order_time=input('order_time','');
        if(!empty($order_sales)){
            $orderflag='sales';
            $orders['order_sales']=$order_sales;
        }elseif (!empty($order_price)) {
            $orderflag='price';
            $orders['order_price']=$order_price;
        }elseif (!empty($order_time)) {
            $orderflag='time';
            $orders['order_time']=$order_time;
        }else{
            $orderflag='';
        };
        $data['city_id']=$this->city->id;
        //根据上面的条件来查询商品列表数据
        $deals=model('Deal')->getDealByConditions($data,$orders);
    //    print_r($deals);exit;
        return $this->fetch('',[
            'categorys'=>$categorys,
            'categoryParentId'=>$categoryParentId,
            'sedcategorys'=>$sedcategorys,
            'id'=>$id,
            'orderflag'=>$orderflag,
            'deals'=>$deals,
        ]);
    }

}