<?php
namespace app\common\model;
use think\Model;
class City extends Model
{
    /**
     * 顶级分类数据，parentID=0
     *
     */
  public function getByParentId($parent_id=0){
     $res=$this->where([
         'parent_id'=>$parent_id,
         'status'=>['<>',-1]
     ])
         ->order([
             'listorder'=>'desc',
             'id'=>'desc',
         ])
         ->select();

     return $res;
  }
    public function getFirstALL(){
        $res=$this->where([
            // 'parent_id'=>0,
            'status'=>['<>',-1]
        ])
            ->order([
                'listorder'=>'desc',
                'id'=>'desc',
            ])
            ->select()
        ;

        return $res;
    }
    public function getById($id){
        $res=$this->where([
             'id'=>$id,
            'status'=>['<>',-1]
        ])
            ->order([
                'listorder'=>'desc',
                'id'=>'desc',
            ])
            ->select()
        ;

        return $res;
    }


    //获取市级城市
    public function getNormalCitys(){
        $where=[
            'status'=>1,
            'parent_id'=>['gt',0],
        ];
        $order=['id'=>'desc'];
        return $this->where($where)
                    ->order($order)
                    ->select();
    }
    public function getByParentIdFIND($pid=0){
        $res=$this->where([
            'id'=>$pid,
            'status'=>['<>',-1]
        ])
            ->order([
                'listorder'=>'desc',
                'id'=>'desc',
            ])
            ->find()
        ;

        return $res;
    }
}