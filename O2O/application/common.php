<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function status($status){
    if($status==1){
        return '<span class="label label-success radius">正常</span>';
    }elseif ($status==0){
        return '<span class="label label-danger radius">未审核</span>';
    }elseif ($status==2){
        return '<span class="label label-danger radius">停用</span>';
    }elseif ($status==-1){
        return '<span class="label label-danger radius">已删除</span>';
    }elseif ($status==3){
        return '<span class="label label-danger radius">审核未通过</span>';
    }
    else{
        return '<span class="label label-danger radius">状态未定义</span>';
    }
}
function verStatus($status){
    if($status==1){
        return '<span class="label label-success radius">已处理</span>';
    }elseif ($status==0){
        return '<span class="label label-danger radius">未解决</span>';
    }elseif ($status==-1){
        return '<span class="label label-danger radius">已删除</span>';
    }elseif ($status==2){
        return '<span class="label label-danger radius">贼TM棘手</span>';
    }
    else{
        return '<span class="label label-danger radius">状态未定义</span>';
    }
}

function doCurl($url, $type=0, $data=[])
{
    $ch = curl_init(); // 初始化
    // 设置选项
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    if ($type == 1) {
        // post
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    //执行并获取内容
      $output = curl_exec($ch);
    // 释放curl句柄
    curl_close($ch);
    return $output;
}
// 商户入驻申请的文案
function bisRegister($status) {
    if($status == 1) {
        $str = "入驻申请成功";
    }elseif($status == 0) {
        $str = "待审核，审核后平台方会发送邮件通知，请关注邮件";

    }elseif($status == 2) {
        $str = "非常抱歉，您提交的材料不符合条件，请重新提交";
    }else {
        $str = "该申请已被删除";
    }
    return $str;
}
/*
 * 通用的分页样式
 * @param $obj
 */
function pagination($obj){
    if(!$obj){
        return '';
    }
    $params=request()->param();//tp5的提取参数的方法
 return '<div class="cl pd-5 bg-1 bk-gray mt-20 tp5-o2o">'.$obj->appends($params)->render().'</div>';
}


function getSeCityName($path) {
    if(empty($path)) {
        return '';
    }
    if(preg_match('/,/', $path)) {
        $cityPath = explode(',', $path);
        $cityId = $cityPath[1];
    }else {
        $cityId = $path;
    }

    $city = model('City')->get($cityId);
    return $city->name;
}
function countlocation($ids){
    if(!$ids){
        return 1;
    }
    if(preg_match('/,/',$ids)){
        $arr=explode(',',$ids);
        return count($arr);
    }
}

//tp5跳转页面优化，检测是否是手机登录更改视图，为了美观
function isMobile()
{
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    if (isset ($_SERVER['HTTP_VIA']))
    {
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}

//api show方法
function show($status,$message,$data=[],$httpCode=200){
    $datas= [
        'status'=>intval($status),
        'message'=>$message,
        'data'=>$data,
    ];
    return json($datas,$httpCode);
}