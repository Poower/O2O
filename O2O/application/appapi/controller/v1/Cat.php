<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/11/21
 * Time: 9:33
 */

namespace app\appapi\controller\v1;

use app\appapi\controller\Common;

class Cat extends Common {
    /**
     * 栏目接口
     */
    public function read(){

        $cats=config('cat.lists');

        $res[]=[
            'catid'=>0,
            'catname'=>'首页'
        ];
        foreach ($cats as $catid=>$catname){
            $res[]=[
              'catid'=>$catid,
              'catname'=>$catname,

            ];
        }
        return show(1,'OK',$res,200);

    }

}