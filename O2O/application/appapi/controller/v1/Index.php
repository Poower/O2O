<?php
namespace app\appapi\controller\v1;
use app\appapi\controller\Common;
use app\appapi\lib\exception\ApiException;

/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/11/24
 * Time: 19:46
 */
class Index extends Common
{
  /**
   * 获取首页接口
   * 1、头图 4-6
   * 2、推荐位列表 默认40条
   */

  public function index(){
      $heads=model('News')->getIndexHeadNornalNews();
      $heads=$this->getDealNews($heads);

      $positions=model('News')->getPositionNormalNews();
      $positions=$this->getDealNews($positions);

      $res=[
          'heads'=>$heads,
          'positions'=>$positions
      ];
      return show(1,'OK',$res,200);

  }

    /**
     * 初始化接口
     * 1、检测APP是否要升级
     */
  public function init(){
     // halt($this->headers);
      //header头信息app_type 去version表查询
      $version=model('Version')->get(['app_type'=>$this->headers['app_type']]);
      if(empty($version)){
          return new ApiException('errormeizhegg',404);
      }

      if($version->version>$this->headers['version']){
          $version->is_update=1;
      }else{
          $version->is_update=0;
      }

      return show(1,'OK',$version,200);
  }
}