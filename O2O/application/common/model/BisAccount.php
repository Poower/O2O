<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/8
 * Time: 19:21
 */

namespace app\common\model;

class BisAccount extends BaseModel
{
   public function updateById($data,$id){
       //allowField 过滤data数组中肥数据表中的数据
       return $this->allowField(true)->save($data,['id'=>$id]);
   }
}