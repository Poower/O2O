<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/8
 * Time: 19:21
 */

namespace app\common\model;
class User extends BaseModel
{

   public function add($data=[]){
       //如果不是数组
       if(!is_array($data)){
             exception('传递的数据不是数组');
       }
       $data['status']=1;
       return $this->data($data)->allowField(true)
           ->save();
   }
   /*
   *根据用户名获取用户信息
   */
   public function getUserByUsername($username){
       if(!$username){
           exception('用户名不合法');
       }
       $where=['username'=>$username];
       return $this->where($where)->find();

   }
}