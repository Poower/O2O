<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/8/7
 * Time: 10:05
 */

namespace app\admin\controller;



class Bis extends Base
{
    /*
     * 入驻申请列表
     * @return mixed
     */
    public function apply(){
        $bis=model('Bis')->getBisByStatus($status=0);
        return $this->fetch('',[
            'bis'=>$bis,
        ]);
    }
    public function detail(){
        $id = input('get.id');
        if(empty($id)) {
            return $this->error('ID错误');
        }

        $citys=model("city")->getByParentId();
        $categorys=model("category")->getFirstALL();
        // 获取商户数据
        $bisData = model('Bis')->get($id);
        $locationData = model('BisLocation')->get(['bis_id'=>$id, 'is_main'=>1]);
        $accountData = model('BisAccount')->get(['bis_id'=>$id, 'is_main'=>1]);
        //dump($locationData);exit;
        $categoryPath=$locationData['category_path'];

        if(strpos($categoryPath,",")){
            $a=strpos($categoryPath,",");
            //dump($a);exit;
            $seCategoryId=substr($categoryPath, $a+1);
        }
        if(strpos($categoryPath,"|")){
        $seCategoryId=explode("|", $categoryPath);
        }else{
            $seCategoryId[]=$categoryPath;
        }
     //   dump($seCategoryId);exit;
        return $this->fetch('',[
            'citys'=>$citys,
            'categorys'=>$categorys,
            'bisData' => $bisData,
            'locationData' => $locationData,
            'accountData' => $accountData,
            'seCategoryId'=>$seCategoryId
        ]);

    }

    //改写集成在base控制器里
//    public function status(){
//        //可以用TP5的validate机制
//        $data=input('get.');
//        //安全措施：1、检测上个页面来源；2、把id和status动态更名让攻击者不能猜测（未实现）
//        $id=$data['id'];
//        $status=$data['status'];
//
//        $res=model('bis')->save(['status'=>$status],['id'=>$id]);
//        $location=model('BisLocation')->save(['status'=>$status],['bis_id'=>$id,'is_main'=>1]);
//        $account=model('BisAccount')->save(['status'=>$status],['bis_id'=>$id,'is_main'=>1]);
//        //三张表都需要改状态
//        if($res&$location&$account){
//            //发送邮件
//            //个人认为出现跳转等待页面的用户体验不佳，直接重定向
//            //$this->success('category/index');
//            $this->redirect('admin/bis/apply');
//        }else{
//            $this->error('更新失败');
//        }
//    }
    public function index(){
     //   $status[]=0;
        $status[]=1;
        $status[]=2;
        $bis=model('Bis')->getBisByStatus($status);
        return $this->fetch('',[
            'bis'=>$bis,
        ]);
        return $this->fetch();
    }
    public function dellist(){
        $status[]=-1;
        $status[]=3;
        $bis=model('Bis')->getBisByStatus($status);
        return $this->fetch('',[
            'bis'=>$bis,
        ]);
       return $this->fetch();
    }


}