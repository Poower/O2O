<?php
namespace app\common\validate;
use think\Validate;

/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/9/30
 * Time: 13:18
 */
class Bis extends Validate
{
   protected $rule=[
       'name'=>'require|max:25',
       'email'=>'email',
       'logo'=>'require',
       'city_id'=>'require',
       'bank_info'=>'require',
       'bank_name'=>'require',
       'bank_user'=>'require',
       'faren'=>'require',
       'faren_tel'=>'require',
   ];
   protected $message=[
       'name.require'=>'名称不能为空的啊',
   ];
   //场景设置
    protected $scene=[
        'add'=>['name','email','logo','city_id','bank_info',
                'bank_name','bank_user','faren','faren_tel']
    ];
}