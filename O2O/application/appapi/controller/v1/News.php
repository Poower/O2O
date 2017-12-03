<?php
namespace app\appapi\controller\v1;
use app\appapi\controller\Common;
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/11/24
 * Time: 19:46
 */
class News extends Common
{
  /**
   * 获取首页接口
   * 1、头图 4-6
   * 2、推荐位列表 默认40条
   */

  public function index(){
      $whereData['status']=config('code.status_normal');
      $whereData['catid']=input('get.catid');
      $total=model('News')->getNewsCountByCondition($whereData);
      echo $total;

  }
}