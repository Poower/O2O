<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/10/25
 * Time: 19:22
 */

namespace app\index\controller;


use think\Controller;

class Map extends Controller
{
    public function getMapimage($data){
      return \Map::staticimage($data);
    }
}