<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/11/24
 * Time: 15:48
 */

namespace app\appapi\lib;


class IAuth{

    /**
     * 生成每次请求的sign
     * @param array $data
     * @return string
     */
    public static function setSign($data=[]){
        //1、按字段排序
        ksort($data);
       //2、拼接数据
        $string=http_build_query($data);
        //3、通过AES来加密
        $str=(new Aes())->encrypt($string);
        return $str;
    }

    /**
     * 检查sign是否正常
     * @param string $sign
     * @param $data
     * @return boolean
     */
    public static function  checkSignPass($data){
       $str= (new Aes())->decrypt($data['sign']);
       if(empty($str)){
           return false;
       }
       parse_str($str,$arr);//将带&字符串转变为数组

        if(!is_array($arr)||empty($arr['did'])
           ||$arr['did']!=$data['did']){
            return false;
        }

        //halt($arr);
        return true;
    }



}