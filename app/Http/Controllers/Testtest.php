<?php

namespace  App\Http\Controllers;
use  app\Libs\simple_html_dom;
class Testtest extends  Controller
{


    public function info()
    {
        $htm = new simple_html_dom();
       // $htm = file_get_html('http://theater.mtime.com/China_Chongqing/');
        $htm->load_file('http://cq.qq.com/');
        //$xml = simplexml_load_string($htm);
       // $ret = $htm->find('a');
       // $rest = $htm->find('div',10)->class='top-news';
        $ret = $htm->find('div.top-news');;
       foreach ($ret as  $re)
       {
           foreach ($re->find('a')as  $se )
           {
               echo $se.'<br/>';
           }
       }
    }

    public function  testmysql()
    {

        $mysqli = new mysqli("localhost", "root", "password");
        if(!$mysqli)  {
            echo"database error";
        }else{
            echo"php env successful";
        }
        $mysqli->close();



    }


        //

//        for($i=0;$i<count($ret);$i++){
//
//           $re[$i]  =  $ret[$i];
//
//
//        }
        //foreach ($ret as  $re)
       // echo $re->plaintext.'<br/>';
       //  foreach ($res as  $re)

//        $ch = curl_init();
//        curl_setopt($ch,CURLOPT_URL,"http://gaoqing.la");
//        curl_setopt($ch, CURLOPT_HEADER, 0);  //0表示不输出Header，1表示输出
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  //设定是否显示头信息,1显示，0不显示。
////如果成功只将结果返回，不自动输出任何内容。如果失败返回FALSE
//
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//        curl_setopt($ch, CURLOPT_ENCODING, '');   //设置编码格式，为空表示支持所有格式的编码
////header中“Accept-Encoding: ”部分的内容，支持的编码格式为："identity"，"deflate"，"gzip"。
//
//       // curl_setopt($ch, CURLOPT_USERAGENT, $UserAgent);
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//        $output = curl_exec($ch);
//        if($output === FALSE ) {
//            echo "CURL Error:" . curl_error($ch);
//
//        }else{
//
//
//            $html->load($output);
//            $ssss= $html->find('ul class="post box row fixed-hight"');
//            echo  $ssss;
//            ｝
//            $info = curl_getinfo($ch);
//            var_dump($output) ;
//            echo ' 获取 '.$info['content_type'].'耗时'.$info['total_time'].'秒';
//
//            // 解析 HTML 的 <head> 区段
//            preg_match("/<head.*>(.*)</head>/smUi",$output, $htmlHeaders);
//            if(!count($htmlHeaders)){
//                echo "无法解析数据中的 <head> 区段";
//                exit;
//            }
//
//// 取得 <head> 中 meta 设置的编码格式
//            if(preg_match("/<meta[^>]*http-equiv[^>]*charset=(.*)(\"|')/Ui",$htmlHeaders[1], $results)){
//                $charset =  $results[1];
//            }else{
//                $charset = "None";
//            }
//
//// 取得 <title> 中的文字
//            if(preg_match("/<title>(.*)</title>/Ui",$htmlHeaders[1], $htmlTitles)){
//                if(!count($htmlTitles)){
//                    echo "无法解析 <title> 的内容";
//                    exit;
//                }
//
//                // 将  <title> 的文字编码格式转成 UTF-8
//                if($charset == "None"){
//                    $title=$htmlTitles[1];
//                }else{
//                    $title=iconv($charset, "UTF-8", $htmlTitles[1]);
//                }
//                echo $title;
//            }
//        }
       // return  view('test/test',['test1'=>'123456','test2'=>'abcdef']);


}



