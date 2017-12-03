<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/8
 * Time: 19:21
 */

namespace app\app\model;
use think\Model;

class Base extends Model
{
    /**
     * 新增
     * @param array|mixed|string $data
     * @return mixed
     */
    public function add($data){
        if(!is_array($data)){
            exception('传递的数据不合法');
        }
        $this->allowField(true)->save($data);
        return $this->id;
    }

}