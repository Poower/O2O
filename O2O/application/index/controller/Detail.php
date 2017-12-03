<?php
namespace app\index\controller;
class Detail extends Base
{
    public function index($id)
    {
      if(!intval($id)){
          $this->error('ID不合法');
      }
      //根据id查询商品的数据
       $deal=model('Deal')->get($id);
      if(!$deal||$deal->status!=1){
          $this->error('该商品不存在');
      }
      //获取分类信息
       $category=model('Category')->get($deal->category_id);
      //获取分店信息
       $locations=model('BisLocation')->getNormalLocationsInId($deal->location_ids);
     //  print_r($locations);exit;
       $flag=0;//表示，判断用
       if($deal->start_time>time()){//还没有开始
           $flag=1;
           $time=$deal->start_time-time();
           $d=$h=$s=0;
           $d=floor($time/(3600*24));//php自带floor函数：取整
           $h=floor($time%(3600*24)/3600);
           $s=floor(($time%(3600*24)%3600)/60);
           $this->assign('d',$d);
           $this->assign('h',$h);
           $this->assign('s',$s);
       }
       $overplus=$deal->total_count-$deal->buy_count;//剩余数量 数据表中无此制度按
      return $this->fetch('',[
          'title'=>$deal->name,
          'locations'=>$locations,
          'category'=>$category,
          'deal'=>$deal,
          'overplus'=>$overplus,
          'flag'=>$flag,
          'mapstr'=>$locations[0]['xpoint'].','.$locations[0]['ypoint'],
      ]);
    }

    public function timetest(){
        echo time();
    }

}
