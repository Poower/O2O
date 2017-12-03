<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/11/15
 * Time: 13:45
 */

namespace app\app\controller;


use think\Controller;

class Login extends Base
{

    public function _initialize(){//覆盖base控制器下的初始方法，否则会死循环redirect

    }
   public function index(){
        $isLogin=$this->isLogin();
        if($isLogin){
            return $this->redirect('index/index');
        }
       return $this->fetch();
       //如果后台用户已经登录让它跳转到后台首页
   }
   public function check(){
       $from=$_SERVER['HTTP_REFERER'];
//       $Aurl='http://'.$_SERVER['SERVER_NAME'].'/app/login/index.html';
//       if($from!=$Aurl){
       if(!stripos($from,'app/Login/index')){
           //strpos 大小写敏感  stripos大小写不敏感    两个函数都是返回str2 在str1 第一次出现的位置
           $this->error('地址来源不对，请不要恶意攻击',url('login/index'));
       }


       $ispost=request()->isPost();
    //   halt($ispost);
       if(!$ispost){
         $this->error('请求不合法');
       }



       $data=input('post.');
      // halt($data);
       //validate 验证 ，没写//tp5的验证码验证只能调用一次，其他验证无恙

         try {
             $res = model('AdminUser')->get(['username' => $data['username']]);
         }catch (\Exception $e){
             $this->error($e->getMessage());
         }
             //   halt($res);
             if (!$res) {
                 $this->error('该用户不存在');
             } elseif ($res->status != config('code.status_normal')) {
                 $this->error('该用户状态不正常');
             }
             if (password($data['password']) != $res['password']) {
                 $this->error('密码错误');
             }

             //更新数据库跳转
             $udata = [
                 'last_login_time' => time(),
                 'last_login_ip' => request()->ip(),//tp5自带的获取IP方法z
             ];
             model('AdminUser')->save($udata, ['id' => $res->id]);


       //存入session
       session('adminuser',$res,'app');
       $this->success('登录成功','app/index/index');
   }

    /**
     * 1、清空session
     * 2、跳转到的航路页面
     */
    public function logout(){
        session(null,'app');
        $this->redirect('login/index');

    }

    /*
     * 用户名验证
     */
    public function namecheck(){
        $data=input('post.');
     //   halt($data);

        $name=input('post.username');
        $res=model('AdminUser')->get(['username'=>$name]);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    /*
     * 密码验证
     */
    public function passwordcheck(){
        $data=input('post.');

        $pmd5=password($data['password']);
     //   halt($pmd5);
        $res=model('AdminUser')->get(['username'=>$data['username']]);
        if($res && $pmd5==$res['password']){
            return true;
        }else{
            return false;
        }

    }

    /*
     * 验证码验证
     */
    public function codecheck($code){

        $check=captcha_check($code);//tp框架的验证码方法,返回布尔值
        if($check){
            return true;

        }else{
            return false;
        };
    }
}