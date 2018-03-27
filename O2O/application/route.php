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
Route::rule('category','admin/Category
Route::post(\'xcx/:version/token/user\',\'xcx/:version.Token/getToken\');//安全性考虑用post/index');

//文件下载
Route::get('/11.23_bak_nopublic.zip');



Route::post('test','appapi/Common/testAes');



Route::get('api/:ver/cat','appapi/:ver.cat/read');
Route::get('api/:ver/index','appapi/:ver.index/index');
Route::get('api/:ver/init','appapi/:ver.index/init');

//news
Route::resource('api/:ver/news','appapi/:ver.news');






/*********************以下是微信小程序的接口路由**********************************************/
Route::get('xcx/banner/:id','xcx/v1.Banner/getBanner');//轮播图数据获取
Route::get('theme/:version/themelist/:ids','xcx/:version.Theme/getSimpleList');//主题列表获取
Route::get('theme/:version/themeproduct/:id','xcx/:version.Theme/getThemeProduct');//单位主题商品获取
Route::get('product/:version/getRencent/:count','xcx/:version.Product/getRencent');//最新商品
Route::get('xcxcategory/:version/all','xcx/:version.Category/getAll');//最新商品
Route::get('xcx/:version/productbycat/:id','xcx/:version.Product/getByCatId');//分类商品
Route::get('xcx/:version/product/:id','xcx/:version.Product/getOne');//分类商品


Route::post('xcx/:version/token/user','xcx/:version.Token/getToken');//获取token，安全性考虑用post


Route::post('xcx/:version/adddress','xcx/:version.Address/Address');//插入或更新地址


Route::post('xcx/:version/order','xcx/:version.Order/placeOrder');//下单接口


Route::post('xcx/:version/pay/pre_order','xcx/:version.Pay/getPreOrder');//下单接口