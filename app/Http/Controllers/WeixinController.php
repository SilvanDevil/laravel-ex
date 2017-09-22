<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Http\Request;
define("TOKEN", "dhsilvan");
class weixinController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    //验证消息

    public function api()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//php:input
        //写入日志  在同级目录下建立php_log.txt
        //chmod 777php_log.txt(赋权) chown wwwphp_log.txt(修改主)
        error_log(var_export($postStr,1),3,'php_log.txt');
        //日志图片

        //extract post data
        if (!empty($postStr)){
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml>
                           <ToUserName><![CDATA[%s]]></ToUserName>
                           <FromUserName><![CDATA[%s]]></FromUserName>
                           <CreateTime>%s</CreateTime>
                           <MsgType><![CDATA[%s]]></MsgType>
                           <Content><![CDATA[%s]]></Content>
                           <FuncFlag>0</FuncFlag>
                           </xml>";
            //订阅事件
//             if($postObj->Event=="subscribe")
//             {
//                 $msgType = "text";
//                 $contentStr = "欢迎关注silvan";
//                 $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
//                 echo $resultStr;
//             }


//             //语音识别
//             if($postObj->MsgType=="voice"){
//                 $msgType = "text";
//                 $contentStr = trim($postObj->Recognition,"。");
//                 $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
//                 echo  $resultStr;
//             }

//             //自动回复
//             if(!empty( $keyword ))
//             {
//                 $msgType = "text";
//                 $contentStr = "学习测试中！";
//                 $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
//                 echo $resultStr;
//             }else{
//                 echo "Input something...";
//             }

//         }else {
//             echo "";
//             exit;
//         }
             switch($msgType){
  case "event":
  if($event=="subscribe"){
  $contentStr = "Hi,欢迎关注海仙日用百货!"."\n"."回复数字'1',了解店铺地址."."\n"."回复数字'2',了解商品种类.";
  } 
  break;
  case "text":
  switch($keyword){
  case "1":
  $contentStr = "店铺地址："."\n"."杭州市江干艮山西路233号新东升市场地下室第一排."; 
  break;
  case "2":
  $contentStr = "商品种类:"."\n"."杯子、碗、棉签、水桶、垃圾桶、洗碗巾(刷)、拖把、扫把、"
   ."衣架、粘钩、牙签、垃圾袋、保鲜袋(膜)、剪刀、水果刀、饭盒等.";
  break;
  default:
  $contentStr = "对不起,你的内容我会稍后回复";
  }
  break;
 }
 $msgType = "text";
 $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
 echo $resultStr;
 }else {
 echo "";
 exit;
 }
 }
    }
    //响应消息
}
