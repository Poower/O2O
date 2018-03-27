<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2018/1/15
 * Time: 15:42
 */

namespace app\lib\exception;


use think\Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorcode;
    //需要返回客户端当前请求的url路径

    public function render(\Exception $e){
        //有点混沌，逻辑还有些不明白，此时以为是：baseexception改写了php的exception，改写
        //部分为：添加了三个属性，各子类对三个属性进行了继承修改，render渲染输出
        //问题是php的错误处理机制搞不明白：什么情况下调用，$e 不能是固化的数据扒

        if($e instanceof BaseException){//instanceof 判断根据是 三个自定义属性
        //如果是自定义的异常,调用写死的写法
            $this->code=$e->code;
            $this->msg=$e->msg;
            $this->errorcode=$e->errorCode;

        }elseif ($e instanceof MyException){
            //传参写法
            $this->code=$e->httpCode;
            $this->msg=$e->message;
            $this->errorcode=$e->code;
        } else{
            $this->recordErrorLog($e);
            //app_dug为true代表开发环境，返回tp5的报错信息；生产环境返回的是json，
            if(config('app_debug')==true){
                return parent::render($e);
            }

            $this->code=500;
            //$this->msg='服务器内部错误，请联系作者';//渲染给客户端的是无用信息，真真实信息记录在自定义log
            $this->msg=$e->getMessage();
            $this->errorcode=999;



    }
    $request=Request::instance();
    $result=[
        'msg'=>$this->msg,
        'error_code'=>$this->errorcode,
      //  'request_url'=>$request->url()
    ];
        return json($result,$this->code);


    }

    private function recordErrorLog(\Exception $e){
        Log::init([
            'type'=>'File',
            'path'=>LOG_PATH,
            'level'=>['error']
        ]);
        Log::record($e->getMessage(),'error');
    }

}