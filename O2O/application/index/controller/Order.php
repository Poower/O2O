<?php
namespace app\index\controller;
class Order extends Base
{
    public function index(){

      //  dump(input('get.'));
        $user=$this->getLoginUser();
        if(!$user){
           $this->error('请登录','user/login');
        }
        $id=input('get.id',0,'intval');
        if(!$id){
            $this->error('参数不合法');
        }
        $dealCount=input('get.deal_count',0,'intval');
        $totalPrice=input('get.total_price',0,'intval');
        $deal=model('Deal')->find($id);
        if(!$deal||$deal->status !=1){
            $this->error('商品不存在');
        }
     if(empty($_SERVER['HTTP_REFERER'])){
            $this->error('请求不合法');
     }
        $orderSn=$this->setOrderSn();
     //组装入库数据
        $data=[
            'out_trade_no'=>$orderSn,//订单号
            'user_id'=>$user->id,
            'username'=>$user->username,
            'deal_id'=>$id,
            'deal_count'=>$dealCount,
            'total_price'=>$totalPrice,
            'referer'=>$_SERVER['HTTP_REFERER'],

        ];
        try{
        $orderId=model('Order')->add($data);
        }catch (\Exception $e){
            $this->error('订单处理失败');
        }
        $this->redirect(url('pay/index',['id'=>$orderId]));
    }
    public function confirm(){
        if(!$this->getLoginUser()){
            $this->error('请登录','user/login');
        }
        $id=input('get.id',0,'intval');
        if(!$id){
            $this->error('参数不合法');
        }
        $count=input('get.count',1,'intval');
        $deal=model('Deal')->find($id);
      //  echo model('Deal')->getLastSql();
        if(!$deal||$deal->status !=1){
            $this->error('商品不存在');
        }
      //  dump($deal);exit;
        $deal=$deal->toArray();
        return $this->fetch('',[
            'controller'=>'pay',
            'deal'=>$deal,
            'count'=>$count,
        ]);
    }

    //设置订单号
    function setOrderSn(){
        //订单号规则：秒加微秒前四位加随机数
//         $a[]=100;
//         $a[]=200;
//         $a[]=300;
//         dump($a);
//         list($q1,$q2,$q3)=$a;
//         dump($q3);
         list($t1,$t2)=explode(' ',microtime());//mircrotime()获取微秒,返回的是数组,第一个值是当前时间的微秒，第二个是当签收的秒,explode分割字符串，list方法为tp5自带
         $t3=explode('.',$t1*10000);
         return $t2.$t3[0].(rand(10000,99999));
    }

}
