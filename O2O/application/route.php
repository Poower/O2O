<?php
use think\Route;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];


//Route::rule('路由表达式','路由地址','请求类型','路由参数（数组）','变量规则（数组）');
Route::rule('category','admin/Category/index');

//文件下载
Route::get('/11.23_bak_nopublic.zip');


Route::post('test','appapi/Common/testAes');



Route::get('api/:ver/cat','appapi/:ver.cat/read');
Route::get('api/:ver/index','appapi/:ver.index/index');
Route::get('api/:ver/init','appapi/:ver.index/init');

//news
Route::resource('api/:ver/news','appapi/:ver.news');
