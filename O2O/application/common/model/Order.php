<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/8
 * Time: 19:21
 */

namespace app\common\model;




class Order extends BaseModel
{
    public function add($data){
        $data['status']=1;
        $res=$this->save($data);
        return $this->id;
    }
    public function updateOrderByOutTradeNo($outTradeTo, $weixinData) {
        if(!empty($weixinData['transaction_id'])) {
            $data['transaction_id'] = $weixinData['transaction_id'];
        }
        if(!empty($weixinData['total_fee'])) {
            $data['pay_amount'] = $weixinData['total_fee'] / 100;
            $data['pay_status'] = 1;
        }

        if(!empty($weixinData['time_end'])) {
            $data['pay_time'] = $weixinData['time_end'];
        }

        return $this->allowField(true)
            ->save($data, ['out_trade_no' => $outTradeTo]);
    }

}