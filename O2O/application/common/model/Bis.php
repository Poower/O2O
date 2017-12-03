<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/8
 * Time: 19:21
 */

namespace app\common\model;




class Bis extends BaseModel
{
    /*
     * 通过状态获取商家数据
     * @param $status
     */
  public function getBisByStatus($status=0){
       $order=[
           'id'=>'desc',

       ];
       $where=[
           'status'=>['in',$status],

       ];
       $result=$this->where($where)
           ->order($order)
           ->paginate();
       return $result;
  }

}