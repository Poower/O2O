<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/9/27
 * Time: 14:29
 */

namespace app\bis\controller;


use think\Controller;

class Register extends Controller
{
     public function index(){
         //获取一级城市数据
         $citys=model("city")->getByParentId();
         $categorys=model("category")->getByParentId();
         return $this->fetch('',[
             'citys'=>$citys,
             'categorys'=>$categorys
         ]);
     }
     public function add(){
         if(!request()->isPost()){
             $this->error('请求错误');
         }
         //获取表单的值
         $data=input('post.');
        // print_r($data);exit;//正常
         //


         //判断用户名是否已经存在  抽空可以写在API里
         $accountResult=model('BisAccount')->get(['username'=>$data['username']]);
         if($accountResult){
             $this->error('该用户已经存在，请重新分配');
         }


        // 基本信息校验数据
         $validate=validate('Bis');
        if(!$validate->scene('add')->check($data)){
         //  dump($validate->getError());
            $this->error($validate->getError());
        }


         //基本信息入库
         $bisData=[
             'name'=>$data['name'],
             'email'=>$data['email'],
             'logo'=>$data['logo'],
             'licence_logo'=>$data['licence_logo'],
             'description' => empty($data['description']) ? '' : $data['description'],
             'city_id' => $data['city_id'],
             'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],//这个字段为一级城市名加二级城市名
             'bank_info' =>  $data['bank_info'],
             'bank_user' =>  $data['bank_user'],
             'bank_name' =>  $data['bank_name'],
             'faren' =>  $data['faren'],
             'faren_tel' =>  $data['faren_tel'],
           //  'status'=>0,
         ];
         $bisId = model('Bis')->add($bisData);


        //总店的相关信息校验
         $account_username=$data['username'];
                  $validate=validate('BisLocation');
        if(!$validate->scene('add')->check($data)){
         //  dump($validate->getError());
            $this->error($validate->getError());
        }

         //获取经纬度
         //print_r($data['address']);
         $lnglat=\Map::getLngLat($data['address']);
         // $lnglat['status']=1;
         //    print_r($lnglat);exit;
         if($lnglat['status']!=0) {
             $this->error('系统错误，如需要帮助，请将数据返回状态码发给我,数据返回状态码为：' . $lnglat['status']);
             //返回码状态表地址http://lbsyun.baidu.com/index.php?title=webapi/guide/
             //webservice-geocoding#8..E8.BF.94.E5.9B.9E.E7.A0.81.E7.8A.B6.E6.80.81.E8.A1.A8
         }elseif (empty($lnglat)){
             $this->error('无数据，请检查网络是否通畅或输入容易辨识地址');}
//         elseif ($lnglat['result']['precise']!=1){
//             $this->error('匹配的地址不精确');
//         }//1为精准匹配，建议不要太精准要求，影响用户体验

        //总店信息入库

         $data['cat'] = '';
         if(!empty($data['se_category_id'])) {
             $data['cat'] = implode('|', $data['se_category_id']);
         }
         // 总店相关信息入库
         $locationData = [
             'account_username'=>$account_username,
             'bis_id' => $bisId,
             'name' => $data['name'],
             'logo' => $data['logo'],
             'tel' => $data['tel'],
             'contact' => $data['contact'],
             'category_id' => $data['category_id'],
             'category_path' => $data['category_id'] . ',' . $data['cat'],
             'city_id' => $data['city_id'],
             'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
             'api_address' => $data['address'],
             'address' => $data['address'],
             'open_time' => $data['open_time'],
             'content' => empty($data['content']) ? '' : $data['content'],
             'is_main' => 1,// 代表的是总店信息
             'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
             'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
             'status'=>0
         ];
         $locationId = model('BisLocation')->add($locationData);

         //账户相关信息校验
         $validate=validate('BisAccount');
         if(!$validate->scene('add')->check($data)){
             //  dump($validate->getError());
             $this->error($validate->getError());
         }
         // 自动生成 密码的加盐字符串
         $data['code'] = mt_rand(100, 10000);
         $accounData = [
             'bis_id' => $bisId,
             'username' => $data['username'],
             'code' => $data['code'],
             'password' => md5($data['password'].$data['code']),
             'is_main' => 1, // 代表的是总管理员
         ];

         $accountId = model('BisAccount')->add($accounData);
         if(!$accountId) {
             $this->error('申请失败');
         }

         //发送邮件
         $url=request()->domain().url('bis/register/waiting',['id'=>$bisId]);//request()->domain() 为调域名的方法
         $title="o2o入驻申请通知";
         $content = "您提交的入驻申请需等待平台方审核，您可以通过点击链接<a href='".$url."' target='_blank'>
                     查看链接</a> 查看审核状态";
         \phpmailer\Email::send($data['email'],$title,$content);
         $this->success('申请成功',url('register/waiting',['id'=>$bisId]));



     }

     public function waiting($id){
         if(empty($id)){
             $this->error('错误来源，不予显示');
         }
         $detail=model('Bis')->get($id);
         return $this->fetch('',[
             'detail'=>$detail,
         ]);
     }
}