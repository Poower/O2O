<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/8
 * Time: 19:21
 */

namespace app\common\model;

class BisLocation extends BaseModel
{
  public function getLocationByStatus($stautus){
      $res=$this->where([
              'status'=>$stautus
          ])
          ->order([
              'id'=>'desc',
          ])
          ->select()
      ;

      return $res;
  }
  public function getNormalLocationByBisId($bisId){
      $where=[
          'bis_id'=>$bisId,
         // 'status'=>1,
      ];
      $result=$this->where($where)
          ->order('id','desc')
          ->select();
      return $result;
  }
  public function getNormalLocationsInId($ids){
      $where=[
          'id'=>['in',$ids],
           'status'=>1,
      ];
      $result=$this->where($where)
  //        ->order('id','desc')
          ->select();
      return $result;
  }
  public function getByUsername($username){
      $where=[
          'account_username'=>$username,
          // 'status'=>1,
      ];
      $result=$this->where($where)
          ->order('id','desc')
          ->select();
      return $result;
  }
}