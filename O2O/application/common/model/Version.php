<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/8
 * Time: 19:21
 */

namespace app\common\model;




class Version extends BaseModel
{
    /*
     * 自用，记录问题，更新版本
     *
     */
   public function getByStatus(){
       $res=$this->where([
           'status'=>['<>',-1]
       ])
           ->order([
               'listorder'=>'desc',
               'id'=>'desc',
           ])
           ->select();

       return $res;
   }

}