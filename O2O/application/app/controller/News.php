<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/11/16
 * Time: 15:25
 */

namespace app\app\controller;


class News extends Base
{
    public function index(){

        //halt(123);
        //模式1

        $data=[
            'catid'=>0,
            'start_time'=>'',
            'end_time'=>'',
            'title'=>'',
        ];
        $where=[];

        $news=model('news')->getNews($where);



        return $this->fetch('',[
           'cats'=>config('cat.lists'),
           'news'=>$news,
            'data'=>$data
        //    'pageTotal'=>$pageTotal,
         //   'curr'=>$whereData['page'],
       ]);
    }
    public function serech(){
        $data=input('param.');
        //halt($data);


        if($data['catid']!=0){$where['catid']=$data['catid'];}
        if(strtotime($data['end_time'])==0){$endtime=time();}else{$endtime=strtotime($data['end_time']);}
        $where['create_time']=['between time',[strtotime($data['start_time']),$endtime]];
        $where['title']=['LIKE','%'.$data['title'].'%'];



        $news=model('news')->getNews($where);

        //模式2  layer
        //$whereData=[];
        //$whereData['page']=!empty($data['page'])?$data['page']:1;
        //$whereData['size']=!empty($data['size'])?$data['size']:config('paginate.list_rows');

        //获取数据
        // $news=model('News')->getNewsByCondition($whereData);
        //获取数据总数，方便得出页数
        //$total=model('News')->getNewsCountByCondition($whereData);
        //$pageTotal=ceil($total/$whereData['size']);//ceil：浮点进1取整

        return $this->fetch('',[
            'cats'=>config('cat.lists'),
            'news'=>$news,
            'data'=>$data
            //    'pageTotal'=>$pageTotal,
            //   'curr'=>$whereData['page'],
        ]);

    }

    public function add(){
        if(request()->isPost()){
           // return $this->result('',0,'新增失败');
            $data=input('post.');
            //validate验证
       //     halt($data);
            //入库操作
            try{
               $id=model('News')->add($data);
            }catch (\Exception $e){
                return $this->result('',0,'新增失败');
            }
            if($id){
                return $this->result(['jump_url'=>url('news/index')],1,'新增成功');
            }else{
                return $this->result('',0,'新增失败');
            }
        }else {
            return $this->fetch('', [
                'cat' => config('cat.lists')
            ]);
        }
    }


}