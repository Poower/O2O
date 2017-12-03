<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/11/21
 * Time: 15:00
 */

namespace app\appapi\lib\exception;


use think\exception\Handle;

class ApiHandleException extends Handle
{
    /**
     * 此处是不可预知的报错，逻辑外的报错，php非语法原生报错文档部分
     * @var int  http状态码，默认500
     */
      public $httpCode=500;

      public function render(\Exception $e){
          if(config('app_debug')==true){//如果生产环境走下边自己写的，返回json，如果是开启debug的测试环境就用tp的报错机制方便定位问题
              return parent::render($e);
          }
          if($e instanceof ApiException){
            //  halt($e);
              $this->httpCode=$e->httpCode;
          }
        return show(0,$e->getMessage(),[],$this->httpCode);
//          $data=[
//              'status'=>0,
//              'message'=>$e->getMessage(),
//              'data'=>[],
//          ];
//          return json($data,$this->httpCode);
      }
}