<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/13
 * Time: 20:21
 */

namespace app\bis\controller;

class Location extends Base
{
    public function index(){
        //逻辑上username是唯一的，一个用户可以有多家店铺，店铺名称可以不一样
        $username=$this->getLoginUser()->username;
      //  dump($username);exit;
        $location=model('BisLocation')->getByUsername($username);
        return $this->fetch('',[
            'location'=>$location
        ]);
    }
    public function add(){
        if(request()->isPost()){
            $data=input('post.');

            //校验数据
            $validate=validate('BisLocation');
            if(!$validate->scene('add')->check($data)){
                //  dump($validate->getError());
                $this->error($validate->getError());
            }

            //门店入库操作
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

            $data['cat'] = '';
            if(!empty($data['se_category_id'])) {
                $data['cat'] = implode('|', $data['se_category_id']);
            }
            $bisId=$this->getLoginUser()->bis_id;
            $username=$this->getLoginUser()->username;

            $locationData = [
                'bis_id' => $bisId,
                'account_username'=>$username,
                'name' => $data['name'],
                'logo' => $data['logo'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'category_id' => $data['category_id'],
                'category_path' => $data['category_id'] . ',' . $data['cat'],
                'city_id' => $data['city_id'],
                'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
                'address' => $data['address'],
                'api_address' => $data['address'],
                'open_time' => $data['open_time'],
                'content' => empty($data['content']) ? '' : $data['content'],
                'is_main' => 0,// 代表的是分店的信息，其他逻辑与数据总店存入一样
                'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
                'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
                'status'=>1
            ];

            $locationId = model('BisLocation')->add($locationData);
            if($locationId){
                return $this->success('分店信息申请成功');
            }else{
                return $this->error('存入失败，请检查数据');
            }
        }else{
            //页面显示
        $citys=model("city")->getByParentId();
        $categorys=model("category")->getByParentId();
        return $this->fetch('',[
            'citys'=>$citys,
            'categorys'=>$categorys
        ]);
        }
    }
    public function detail($id){
        $location=model('BisLocation')->find($id);
        $cityId=$location->city_id;
      //  print_r($cityId);exit;
       // var_dump($location);exit;

        return $this->fetch('',[
            'location'=>$location,
        ]);

    }
    public function status(){
        $data=input('get.');
        $id=$data['id'];
        $status=$data['status'];
        $location=model('BisLocation')->save(['status'=>$status],['id'=>$id]);
    }
}