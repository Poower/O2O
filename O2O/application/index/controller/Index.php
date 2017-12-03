<?php
namespace app\index\controller;
class Index extends Base
{
    public function index()
    {
        //获取首页大图相关数据
        $banners=model('Featured')->getByType(0);
        $ads=model('Featured')->getByType(1);
        $this->assign('banners',$banners);
        $this->assign('ads',$ads);
        //获取广告位数据

        //商品分类数据 美食 推荐的数据
        $datas=model('Deal')->getNormalDealByCategoryCityId(2,$this->city->id);
       // print_r($datas);exit;
        $this->assign('datas',$datas);
        $meishicates = model('Category')->getNormalRecommendCategoryByParentId(1, 4);
        $this->assign('meishicates',$meishicates);

      return $this->fetch();
    }

}
