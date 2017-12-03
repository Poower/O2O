<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/8
 * Time: 19:21
 */

namespace app\app\model;
use think\Model;

class News extends Base
{
  public function getNews($where=[]){
//      $data['status']=[
//          'neq',config('code.status_delete')
//      ];
      $code=config("code.status_delete");
      $where['status']=['neq',$code];

      $order=['id'=>'desc'];
      $res=$this->where($where)
          ->order($order)
          ->paginate();
      echo $this->getLastSql();
      return $res;
  }

    /**
     * @param array $param
     * 根据条件获取数据
     */
  public function getNewsByCondition($param=[]){
      $code=config("code.status_delete");
      $condition=[
          'status'=>['neq',$code],
      ];
      $order=['id'=>'desc'];
      $form=($param['page']-1)*$param['size'];

      $res=$this->where($condition)
          ->limit($form,$param['size'])
          ->order($order)
          ->select();
      echo $this->getLastSql();
      return $res;

  }

  public function getNewsCountByCondition($param=[]){
      $condition['status']=[
          'neq',config('code.status_delete')
      ];
      $res=$this->where($condition)
          ->count();
   //  echo $this->getLastSql();
      return $res;
  }

}