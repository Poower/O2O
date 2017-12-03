<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/12/3
 * Time: 5:08
 */

namespace app\crm\controller;


use think\Controller;

class Customers extends Controller
{
    public function index(){

        //自用写入数据
// $xing=['张','黄','李','马','赵','钱','孙','周','吴','郑','王','刘','朱'];
// $ming=['大','二','三','四','五','六','七','八','九'];
// $fuzerena=['工号110','工号120','工号119','工号001'];
//
//
//     for ($q=1;$q<101;$q++){
//     $name=$name=$xing[array_rand($xing)].$ming[array_rand($ming)];
//     $type=rand(0,2);
//     $tel=1;
//     for ($j=0;$j<9;$j++){
//
//         $tel.=rand(0,9);
//     }
//     $fuzeren=$fuzerena[array_rand($fuzerena)];
//     $plantime=time()+rand(1000,1000000);
//     $createtime=time()-rand(1000,1100000);
//     $updatetime=$createtime+rand(1,time()-$createtime);
//     $content='这是第'.$q.'条备注';
//     $record='这是第'.$q.'条记录';
//         //model函数有过滤，只能弄一次
//         $user = new \app\crm\model\Customers();
//         $user->data([
//             'name'=>$name,
//             'type'=>$type,
//             'tel'=>$tel,
//             'fuzeren'=>$fuzeren,
//             'content'=>$content,
//             'record'=>$record,
//             'plantime'=>$plantime,
//             'create_time'=>$createtime,
//             'update_time'=>$updatetime
//         ]);
//         $user->save();
//     }


//        创建数据表的时候忘写了status字段，补上
//        for ($i=0;$i<100;$i++){
//            $user = new \app\crm\model\Customers();
//// save方法第二个参数为更新条件
//            $user->save([
//                'status' => rand(-2,3),
//
//            ],['id' => $i]);
//        }




        $status=[0=>'初访',1=>'意向',2=>'报价',3=>'成交',-1=>'未成交',-2=>'搁置'];
       // $typee=['www'=>'A(重要客户)','B(普通客户)','C(低价值客户)'];
        $type[0]='A(重要客户)';
        $type[1]='B(普通客户)';
        $type[2]='C(低价值客户)';
        $post=input('post.');
        $get=input('param.');
        if(!$post){
            $get['bumen']=$get['fuzeren']=$get['start_time']=$get['end_time']='';
        }
      // dump($get);
        unset($get['page']);
        $where=array_filter ($get);//array_filter php函数，去除空元素
    //    dump($where);


        $data=model('customers')->getWhereData($where);


        return $this->fetch('',[
            'data'=>$data,
            'status'=>$status,
            'type'=>$type,
            'get'=>$get,
        ]);

    }

}