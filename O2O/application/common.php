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
function myCurl($url,$type=0, $data=[]){
// 1. 初始化
    $ch = curl_init();
    // 2. 设置选项，包括URL
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER,0);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);//https要写这两段

    if ($type == 1) {
        // 1为post，默认为0：get
        //
        //   curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);//5.5之前版本模拟form表单post文件需开启此项
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    // 3. 执行并获取HTML文档内容
    $output = curl_exec($ch);
    if($output === FALSE ){
        echo "CURL Error:".curl_error($ch);
    }
    // 4. 释放curl句柄
    curl_close($ch);
    return $output;
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


/**
 * memcache缓存写入数据
 * @param $key
 * @param $value
 * @param $expire_in
 */
function memcacheSet($key,$value,$expire_in){
    $mem=new \Memcache();

    $host='127.0.0.1';
    $port='11211';
    $mem->addServer($host,$port);

    //更改分布式要记得flush
//    $host='39.106.118.149';
//    $port='11211';
//    $mem->addServer($host,$port);

    $res=$mem->set($key,$value,0,time()+$expire_in);
    if($res!==true){
        throw new \app\lib\exception\MyException('memcache存入出错');
    }



    $mem->close();
}


/**
 * 取出memcache缓存
 * @param $key
 * @return array|string
 * @throws \app\lib\exception\MyException
 */
function memcacheGet($key){
    $mem=new \Memcache();

    $host='127.0.0.1';
    $port='11211';
    $mem->addServer($host,$port);
//
//    $host='39.106.118.149';
//    $port='11211';
//    $mem->addServer($host,$port);

    // $mem->flush();

    $res=$mem->get($key);
    if($res==false){
        throw new \app\lib\exception\MyException('数据已失效');
    }

    return $res;


    $mem->close();
}

/*
 * redis头
 * @param 数据库编号，默认为0
 * 当redis 服务器初始化时，会预先分配 16 个数据库（该数量可以通过配置文件配置）
 */
function redis($db_id=\app\lib\enum\RedisDbIdEnum::o2o){
    $redis=new \Redis();
    $return=$redis->connect(config('redis.host'),6379);
    //$return=$redis->connect('127.0.0.1',6379);
    if($return !==true){
        throw new \think\Exception('redis连接失败');
    }
    $return=$redis->auth(config('redis.password')); //密码验证
    if($return !==true){
        throw new \think\Exception('redis-auth:密码有误，请更改配置');
    }
    $redis->select($db_id);//选择数据库2

    return $redis;
}

/**
 * 自写自用日志记录
 * @param $data
 */
function mylog($data){
         $data=json_encode($data,JSON_UNESCAPED_UNICODE);

         $data= str_replace(",","\r\n",$data);

         $data= str_replace("}","}\r\n",$data);

        file_put_contents("../mylog/mylog.txt", date('Y-m-d H:i:s',time())."\r\n".$data."\r\n".'-----------------------------------------'."\r\n", FILE_APPEND);



   // $data=json_encode($data);
   // file_put_contents("../mylog/mylog.txt", date('Y-m-d H:i:s',time())."\r\n".$data."\r\n".'-----------------------------------------'."\r\n", FILE_APPEND);
}



