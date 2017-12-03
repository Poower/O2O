<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/8
 * Time: 19:21
 */

namespace app\appapi\model;
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
  public function getNewsByCondition($condtion=[]){
      if(!isset($condition['status'])){
          $code=config("code.status_delete");
          $condition=[
              'status'=>['neq',$code],
          ];
      }

      $order=['id'=>'desc'];
    //  $form=($param['page']-1)*$param['size'];

      $res=$this->where($condition)
    //      ->limit($form,$param['size'])
          ->order($order)
          ->select();
      echo $this->getLastSql();
      return $res;

  }

  public function getNewsCountByCondition($condition=[]){
      if(!isset($condition['status'])){
          $code=config("code.status_delete");
          $condition=[
              'status'=>['neq',$code],
          ];
      }
      $res=$this->where($condition)
          ->count();
   //  echo $this->getLastSql();
      return $res;
  }


    /**
     * 获取首页头图
     * @param int $num
     */
  public function getIndexHeadNornalNews($num=4){
      $data=[
          'status'=>1,
          'is_head_figure'=>1
      ];
      $order=[
          'id'=>'desc'
      ];
      return $this->where($data)
          ->field($this->getListField())
          ->order($order)
          ->limit($num)
          ->select();

  }

    /**
     * 获取推荐的数据
     */
  public function getPositionNormalNews($num=20){
      $data=[
          'status'=>1,
          'is_position'=>1
      ];
      $order=[
        'id'=>'desc',
      ];
      return $this->where($data)
          ->field($this->getListField())
          ->order($order)
          ->limit($num)
          ->select();

  }
  private function getListField(){
      return[
          'id',
          'catid',
          'image',
          'title',
          'read_count'
      ];
  }

}