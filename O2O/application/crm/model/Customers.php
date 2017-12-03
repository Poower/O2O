<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/12/3
 * Time: 18:06
 */

namespace app\crm\model;


use think\Model;

class Customers extends Model
{
  public function getAllData(){
      $order=[
          'id'=>'desc',

      ];

      $result=$this
          ->order($order)
          ->paginate(8);
      return $result;

  }
  public function getWhereData($where=''){
      $order=[
          'id'=>'desc',

      ];

      $result=$this->where($where)
          ->order($order)
          ->paginate(8);
      return $result;

  }
}