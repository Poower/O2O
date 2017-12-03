<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/11/15
 * Time: 17:00
 */

//密码加盐验证
 function password($data){
    $res=md5($data.'#@poower');
    return $res;
}

/**
 * @param $obj
 * @return string
 * 分页和公共common一样，以后可以改单独页面的分页样式
 * tp：如果和公共common同名就会报错
 */
function pagination_app($obj){
    if(!$obj){
        return '';
    }
    $params=request()->param();
    return '<div class="poower-app">'.$obj->appends($params)->render().'</div>';
   // return '<div class="cl pd-5 bg-1 bk-gray mt-20 tp5-o2o">'.$obj->appends($params)->render().'</div>';
}

/**
 * 获名称取栏目
 * @param $cid
 * @return mixed
 *
 */
function getCatName($catid){
    if(!$catid){
        return '';
    }
    $lists=config('cat.lists');
    if(!empty($lists[$catid])){
        $res='';
    }
    $res=$lists[$catid];

    return $res;

}

function isYesNo($str){
    return $str?'<span style="color:green">是</span>':'<span style="color: black">否</span>';

}

