<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/11/22
 * Time: 9:48
 */

namespace app\appapi\controller;


use app\appapi\lib\exception\ApiException;
use app\appapi\lib\IAuth;
use think\Controller;
use app\appapi\lib\Aes;

/**
 * appapi模块公共的控制器
 * Class Common
 * @package app\appapi\controller
 */
class Common extends Controller
{
    /**
     * 定义header头
     * @var string
     */
    public $headers='';
    /*
     * 初始化的方法
     * 校验数据是否合法，安全性，sign
     */

     public function _initialize(){
         $this->headers=request()->header();
         if(config('sign')){//sign是否开启  true:开启；false：关闭

             $this->checkRequesrAuth();//sign安全验证
         }




       //  $this->testAes();

     }

     /*
      * 检查每次app请求的数据是否合法
      */
     public function checkRequesrAuth(){
         //本项目sign是写在header里
         //首先需要获取header里面的数据
         $headers=request()->header();

        // halt($headers);

         //sign加密是需要客户端工程师做的  解密需要服务端工程师做
         if(empty($headers['sign'])){
             throw new ApiException('sign不存在',400);
         }
         if(!in_array($headers['app_type'],config('app.apptypes'))){
             throw new ApiException('app_type不合法',400);
         }
         //生成sign
       //  $str=IAuth::setSign($headers['sign']);
         if(!IAuth::checkSignPass($headers)){
             throw new ApiException('授权码sign验证失败',401);
         }
         $this->headers=$headers;
     }
     public function testAes(){
//         $cipher_list = mcrypt_list_algorithms();//mcrypt支持的加密算法列表
//         $mode_list = mcrypt_list_modes();	//mcrypt支持的加密模式列表
//
//        // echo '<xmp>';
//         print_r($cipher_list);
//         print_r($mode_list);
         $headers=request()->header();
         $d=(new IAuth())->setSign($headers);
         echo $d;
        // $e=(new Aes())->decrypt($d);
        // dump($e);
     }

    /**
     * 获取处理的新闻的内容数据
     * @param array $news
     * @return array
     */
    protected  function getDealNews($news = []) {
        if(empty($news)) {
            return [];
        }

        $cats = config('cat.lists');

        foreach($news as $key => $new) {
            $news[$key]['catname'] = $cats[$new['catid']] ? $cats[$new['catid']] : '-';
        }

        return $news;
    }

}