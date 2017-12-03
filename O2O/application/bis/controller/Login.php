<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/9/27
 * Time: 14:29
 */

namespace app\bis\controller;


use think\Controller;

class Login extends Controller
{
     public function index(){
         if(request()->isPost()){
             //登录的逻辑
             //获取相关的数据
             $data=input('post.');
             //通过用户名获取用户相关信息
            $ret=model('BisAccount')->get(['username'=>$data['username']]);
         //   dump($ret);exit;
            if(!$ret){
                $this->error('该用户不存在');
            }elseif ($ret->status!=1){
                $this->error('该用户审核状态不正常');
            }
            if($ret->password!=md5($data['password'].$ret->code)){
                $this->error('密码不正确');
            }
            model('BisAccount')->updateById(['last_login_time'=>time()],$ret->id);
            //保存用户信息 bis是作用域
             session('bisAccount',$ret,'bis');
             return $this->success('登陆成功',url('index/index'));
         }else{
             //获取session值
             $account=session('bisAccount','','bis');
             if($account&&$account->id){
                 return $this->redirect(url('index/index'));
             }
         return $this->fetch();
         }
     }
     public function password(){
         //自己改密码用的，没前台展示，直接在这修改就行了
         $name='admin';
         $password='admin';
         $code=mt_rand(100, 10000);
         $p=md5($password.$code);
         $ret=model('BisAccount')->save(['password'=>$p,'code'=>$code],['username'=>$name]);

         return $ret;
        // var_dump($ret);
     }
     public function logout(){
         //清除session
         session(null,'bis');
         //跳出
         $this->redirect('login/index');
     }
}