<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/8
 * Time: 19:21
 */

namespace app\common\model;




class Featured extends BaseModel
{
    /**
     * //根据类型来获取推荐位数据
     * @param $type
     * @return \think\Paginator|\think\paginator\Collection
     */
   public function getByType($type){
       $where=[
           'type'=> $type,
           'status'=> ['neq',-1],//-1代表删除，所以取出的是非删除的数据
       ];
       $order=[
           'id'=>'desc',
       ];
       $res=$this->where($where)
           ->order($order)
           ->paginate();
       return $res;
   }
}