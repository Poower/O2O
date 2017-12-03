<?php
namespace app\common\model;
use think\Model;
class Category extends Model
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
         ->select()
         ;

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
    public function getNormalRecommendCategoryByParentId($id=0,$limit=5){
          $where=[
              'parent_id'=>$id,
              'status'=>1,
          ];
          $order=[
              'listorder'=>'desc',
              'id'=>'desc',
          ];
          $result=$this->where($where)
              ->order($order);
          if($limit){
              $result=$result->limit($limit);
          }
          return $result->select();
    }
    public function getNormalCategoryIdParentId($ids){

        $where=[
            'parent_id'=>['in',implode(',',$ids)],
            'status'=>1,
        ];
        $order=[
            'listorder'=>'desc',
            'id'=>'desc',
        ];
        $result=$this->where($where)
            ->order($order)
            ->select();

        return $result;
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