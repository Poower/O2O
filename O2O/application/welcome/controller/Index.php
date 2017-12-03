<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/11/22
 * Time: 14:03
 */

namespace app\welcome\controller;


use think\Controller;


class Index extends Controller
{
     public function index(){

         //文件操作，测试用，为了代码安全可以定时备份文件
//         $myfile = fopen("../testfile.txt", "w");
//         $txt = "Bill Gates\n";
//         fwrite($myfile, $txt);
//         $txt = "Steve Jobs\n";
//         fwrite($myfile, $txt);
//         fclose($myfile);
//
//         $file = './../application/route.php';
//         $newfile = 'ji.txt'; # 这个文件父文件夹必须能写
//         if (file_exists($file) == false) {
//             die ('小样没上线,无法复制');
//         }
//         $result = copy($file, $newfile);
//         if ($result == false) {
//             echo '复制记忆ok';
//         }

//
//         if(time()>1512210700){
//             @unlink("../testfile.txt");
//             echo 'shanle';
//         }
//         halt(time());

        return $this->fetch();
     }
     public function susu(){
         return $this->fetch();
     }
     public function susucheck($name){
         if($name!='二牛'){
             $this->error('姓名验证不通过',('index/index'));
         }
     }
     public function download(){

         header("Content-type: application/octet-stream");
         header('Content-Disposition: attachment; filename="welcome.jpg"');
         header("Content-Length: __STATIC__/");
     }
     public function phpinfo(){
         echo phpinfo();
     }
}