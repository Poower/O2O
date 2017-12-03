<?php
namespace app\index\controller;

use think\Controller;

class User extends Controller
{
    public function login()
    {
        //获取session值
        $user=session('o2o_user','','o2o');
        if($user && $user->id){
            $this->redirect(url('index/index'));
        }
      return $this->fetch();
    }
    public function register()
    {
        if(request()->isPost()){
            $data=input('post.');
         //   halt($data);
//            $check=captcha_check($data['verifycode']);//tp框架的验证码方法,返回布尔值
//            if(!$check){
//                $this->error('验证码不正确');
//            }
            //此处有一个问题：为了用户体验验证码验证用的jquery验证，若攻击者绕过验证怎么办：限定ip限定时间内申请数量

            //tp的validate机制验证
            if($data['password']!=$data['repassword']){
                $this->error('两次输入的密码不一样');
            }
            // 自动生成 密码的加盐字符串
            $data['code'] = mt_rand(100, 10000);
            $data['password']=md5($data['password'].$data['code']);

            try{
                $res=model('User')->add($data);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }

            if($res){
                $this->success('注册成功',url('user/login'));
            }else{
                $this->error('注册失败');
            }
        }else{
        return $this->fetch();
        }
    }
    public function logincheck(){
        if(!request()->isPost()){
            $this->error('提交不合法');
        }
        $data=input('post.');
        //使用tp5的validate机制验证数据
        try{
        $user=model('User')->getUserByUsername($data['username']);
        }catch (\Exception $e){
            $this->error($e->getMessage() );
        }
        //判断用户名是否存在
        if(!$user){
            $this->error('该用户不存在');
        }elseif ($user->status!=1){
            $this->error('该用户状态异常');
        }
        //判定密码是否正确
        $password=md5($data['password'].$user->code);
        if($password !=$user->password){
            $this->error('密码错误');
        }
        //登录成功，记录登录时间
        model('User')->updateById(['last_login_time'=>time()],$user->id);

    //把用户信息记录到session
    session('o2o_user',$user,'o2o');
    $this->redirect($_SERVER['HTTP_REFERER'] );
    }

    public function logout(){
        session(null,'o2o');
        $this->redirect(url('user/login'));
    }

    public function close(){
        echo '<script>window.close();</script>';
    }


    //注册页面ajax判断
    public function namecheck(){
        $username=input('post.username');
            $res=model('user')->get(['username'=>$username]);
        if($res){
            return false;
        }else{
            return true;
        };

    }
    public function emailcheck(){
        $email=input('post.email');
        $res=model('user')->get(['email'=>$email]);
        if($res){
            return false;
        }else{
            return true;
        };

    }
    public function codecheck(){
        $verifycode=input('post.verifycode');
        $check=captcha_check($verifycode);//tp框架的验证码方法,返回布尔值
        if($check){
            return true;
        }else{
            return false;
        };
    }

    //登录页面ajax判断
    public function namecheckL($username){
        $res=model('user')->get(['username'=>$username]);
        if($res){
            return true;
        }else{
            return false;
        };

    }
    public function passwordcheck(){
        $data=input('post.');


        //   halt($pmd5);
        $res=model('User')->get(['username'=>$data['username']]);
        $pmd5=md5($data['password'].$res['code']);
        if($res && $pmd5==$res['password']){
            return true;
        }else{
            return false;
        }

    }

    //作者改密码用的
    public function paswordgagigissngsigsnfnfs(){
        $name='admin';
        $res=model('User')->get(['username'=>$name]);
        $code=$res['code'];
        $p=md5('admin'.$code);
        model('User')->save(['password'=>$p],['username'=>$name]);
    }

}
