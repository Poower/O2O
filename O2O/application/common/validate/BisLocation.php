<?php
namespace app\common\validate;
use think\Validate;

/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/9/30
 * Time: 13:18
 */
class BisLocation extends Validate
{
   protected $rule=[
       'tel'=>'number',
       'address'=>'require',
       'logo'=>'require',
       'city_id'=>'require',
       'contact'=>'require',//联系人
       'category_id'=>'require',//分类
       'content'=>'require',//简介
       'name'=>'require|max:100',
     //  'account_username'=>'require'


   ];
   protected $message=[
       'name.require'=>'名称不能为空的啊',
  //     'username.require'=>'用户名必须的，请检查session是否失效或重新登录',
   ];
   //场景设置
    protected $scene=[
        'add'=>['name','tel','address','logo','city_id','contact','category_id','content','name']
    ];
}