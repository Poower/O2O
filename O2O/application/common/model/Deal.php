<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/8
 * Time: 19:21
 */

namespace app\common\model;




class Deal extends BaseModel
{
    /*
     * 通过状态获取商家数据
     * @param $status
     */
    //查找数据的方法
     public function getNormalDeals($data=[]){
        // $data['status']=1;
         $order=['id'=>'desc'];

         $res=$this->where($data)
             ->order($order)
             ->paginate();
         echo $this->getLastSql();
         return $res;
     }
     /*
      * 根据分类以及城市来获取商品
      *@param $id 分类
      * @param $城市 cityId
      * @param int $limit 条数
      */
     public function getNormalDealByCategoryCityId($id,$cityId,$limit=10){
           $where=[
              // 'coupons_end_time' =>['gt',time()],
               'category_id'=>$id,
               'city_id'=>$cityId,
               'status'=>1,
           ];
          $order=[
              'listorder'=>'desc',
              'id'=>'desc',
          ];
          $res= $this->where($where)
              ->order($order);
          if($limit){
              $res=$res->limit($limit);
          }
          return $res->select();
     }
     public function getDealByConditions($data=[],$orders){
           if(!empty($orders['order_sales'])){
             $order['buy_count']='desc';
         }
         if(!empty($orders['order_price'])){
             $order['current_price']='desc';
         }
         if(!empty($orders['order_time'])){
             $order['create_time']='desc';
         }
         //find_in_set()为MySQL函数
         $order['id']='desc';
         //$datas[] = ' end_time> '.time();
         $datas[] = ' status= 1';

         if(!empty($data['se_category_id'])) {

             $datas[]="find_in_set(".$data['se_category_id'].",se_category_id)";
         }
         if(!empty($data['category_id'])) {

             $datas[]="category_id = ".$data['category_id'];
         }
         if(!empty($data['city_id'])) {

             $datas[]="city_id = ".$data['city_id'];
         }

         $result = $this->where(implode(' AND ',$datas))
             ->order($order)
             ->paginate();
     // echo $this->getLastSql();exit;
         return $result;
     }

    public function updateBuyCountById($id, $buyCount) {
        return $this->where(['id' => $id])->setInc('buy_count', $buyCount);

    }
    public function getByBisId($bisId){
        $where=[

            'bis_id'=>$bisId,
            'status'=>1,
        ];
        $order=[
            'id'=>'desc',
        ];
        $res= $this->where($where)
            ->order($order)
            ->select();

        return $res;
    }

}