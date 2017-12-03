<?php
namespace app\common\validate;
use think\Validate;
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/9/30
 * Time: 13:18
 */
class BisAccount extends Validate
{
    protected $rule=[
        'username'=>'require|max:18',
        'password'=>'require|max:18',

    ];
    protected $message=[
        'username.require'=>'用户名不得为空',
        'password.require'=>'密码不得为空',
    ];
    //场景设置
    protected $scene=[
        'add'=>['username','password']
    ];
}