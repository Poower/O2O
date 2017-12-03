<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/17
 * Time: 12:55
 */

namespace app\bis\controller;
class Deal extends Base
{
    public function index(){
        $bisId=$this->getLoginUser()->bis_id;
        $data=model('Deal')->getByBisId($bisId);
      return $this->fetch('',[
          'data'=>$data,
      ]);
    }

    public function add(){
        $bisId=$this->getLoginUser()->bis_id;
        if(request()->isPost()){
            //走插入逻辑
            $data=input('post.');
            //validate验证
            $location = model('BisLocation')->get($data['location_ids'][0]);
            $deals=[
                'bis_id' => $bisId,
                'name' => $data['name'],
                'image' => $data['image'],
                'category_id' => $data['category_id'],
                'se_category_id' => empty($data['se_category_id']) ? '' : implode(',', $data['se_category_id']),
                'city_id' => $data['city_id'],
                'location_ids' => empty($data['location_ids']) ? '' : implode(',', $data['location_ids']),
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'total_count' => $data['total_count'],
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'notes' => $data['notes'],
                'description' => $data['description'],
                'bis_account_id' => $this->getLoginUser()->id,
                'xpoint' => $location->xpoint,
                'ypoint' => $location->ypoint,

            ];
            $id = model('Deal')->add($deals);
            if($id) {
                $this->success('添加成功', url('deal/index'));
            }else {
                $this->error('添加失败');
            }

        }else{
        //获取一级城市数据
        $citys=model("city")->getByParentId();
        $categorys=model("category")->getByParentId();
        return $this->fetch('',[
            'citys'=>$citys,
            'categorys'=>$categorys,
            'bislocations'=>model('BisLocation')
            ->getNormalLocationByBisId($bisId),
           ]);
        }
    }

}