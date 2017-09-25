<?php

namespace App\Http\Controllers;
use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
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
//        $echoStr = $_GET["echostr"];
//        if ($this->checkSignature()) {
//            echo $echoStr;
//            exit;
//        }
//    }
        //get post data, May be due to the different environments
        //   $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//php:input  收不到信息!!!!!!
        $postStr = file_get_contents("php://input");
        //写入日志  在同级目录下建立php_log.txt
        //chmod 777php_log.txt(赋权) chown wwwphp_log.txt(修改主)
        error_log(var_export($postStr, 1), 3, "php_log.txt");
        //日志图片

        //extract post data
        if (!empty($postStr)) {
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $msgType = $postObj->MsgType;//消息类型
            $event = $postObj->Event;//时间类型，subscribe（订阅）、unsubscribe（取消订阅）
            $time = time();
            $textTpl = "<xml>
                           <ToUserName><![CDATA[%s]]></ToUserName>
                           <FromUserName><![CDATA[%s]]></FromUserName>
                           <CreateTime>%s</CreateTime>
                           <MsgType><![CDATA[%s]]></MsgType>
                           <Content><![CDATA[%s]]></Content>
                           <FuncFlag>0</FuncFlag>
                           </xml>";

            $newsTpl= "<xml>
                           <ToUserName><![CDATA[%s]]></ToUserName>
                           <FromUserName><![CDATA[%s]]></FromUserName>
                           <CreateTime>%s</CreateTime>
                           <MsgType><![CDATA[%s]]></MsgType>
                           <ArticleCount>2</ArticleCount>
                           <Articles>
                           <item>
                           <Title><![CDATA[%s]]></Title>
                           <Description><![CDATA[%s]]></Description>
                           <PicUrl><![CDATA[%s]]></PicUrl>
                           <Url><![CDATA[%s]]></Url>
                           </item>
                           </Articles>
                           </xml>";
                            
//            $newsTplBody = "<item>
//                <Title><![CDATA[%s]]></Title>
//                <Description><![CDATA[%s]]></Description>
//                <PicUrl><![CDATA[%s]]></PicUrl>
//                 <Url><![CDATA[%s]]></Url>
//                </item>";
//            $newsTplBody2 = "<item>
//                <Title><![CDATA[%s]]></Title>
//                <Description><![CDATA[%s]]></Description>
//                <PicUrl><![CDATA[%s]]></PicUrl>
//                 <Url><![CDATA[%s]]></Url>
//                </item>";
//            $newsTplFoot = "</Articles>
//                </xml>";

//            $url = 'https://api.douban.com/v2/movie/in_theaters?count=10';
//            $result = file_get_contents($url);
//            $jsonArray = json_decode($result,true);
//            $a['title']=$jsonArray['subjects'][0]['title'];
//            $c['large']=$jsonArray['subjects'][0]['images']['large'];
          //  $a1['title']=$jsonArray['subjects'][1]['title'];
           // $c1['large']=$jsonArray['subjects'][1]['images']['large'];
//            $url1 = 'https://api.douban.com/v2/movie/subject/25808075';
//            $result1 = file_get_contents($url1);
//            $jsonArray1 = json_decode($result1,true);
//            $b['summary']=$jsonArray1['summary'];
//            $url2 = 'https://api.douban.com/v2/movie/subject/22266126';
//            $result1 = file_get_contents($url2);
//            $jsonArray1 = json_decode($result1,true);
        //    $b1['summary']=$jsonArray1['summary'];
//            for($i=1;$i<=9;$i++){
//
//                //  $dh['title']=;
//                array_push($ds['title'],$jsonArray['subjects'][$i]['title']);
//            }

            //订阅事件
            if ($postObj->Event == "subscribe") {
                $msgType = "text";
                $contentStr = "欢迎关注silvan，目前属于学习测试阶段";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;

            }


            //语音识别
            if ($postObj->MsgType == "voice") {
                $msgType = "text";
                $contentStr = trim($postObj->Recognition, "。");
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;

            }

            //自动回复
            if (!empty($keyword)) {
                if($keyword=="电影预告"){
                    $msgType="news";
                    $title = $this->searchMovieTitle($keyword);
                    $desc = $this->searchMovieSummary($keyword);
                    $picUrl = $this->searchMovieImage($keyword);
                    $Url = $this->searchMovieMobileUrl($keyword);
                    $results = sprintf($newsTpl, $fromUsername,$toUsername,$time,$msgType,$title, $desc, $picUrl,$Url);
                    echo  $results;
                   // $header=sprintf($newsTplHead, $fromUsername,$toUsername,$time,$msgType);
                  //  $body=sprintf($newsTplBody,$title, $desc, $picUrl,$Url);
                    //   $url = $newsContent['url'];
                    //  $body = sprintf($newsTplBody, $title, $desc, $picUrl);

                    //$FuncFlag = 0;
                    // $footer = sprintf($newsTplFoot, $FuncFlag);
                     //$results=$header.$body.$body1.$newsTplFoot;

                }else{
                    $msgType = "text";
                    $contentStr = "非常抱歉，没有搜索您的电影！";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }


            } else {
                echo "Input something...";

            }


        } else {
            echo "";
            error_log("postStr 空文件", 3, "php_log.txt");
            exit;
        }
    }

    //检查签名
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = "dhsilvan";
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
    }

    public  function  searchMovieId($movie){
        $UrlSr='https://api.douban.com/v2/movie/search?q='.$movie;
        $result = file_get_contents($UrlSr);
        $jsonArray = json_decode($result,true);
        $id=$jsonArray['subjects'][0]['id'];
        return  $id;
    }

    public function   searchMovieSummary($id){
        $UrlSr='https://api.douban.com/v2/movie/subject/'.$id;
        $result = file_get_contents($UrlSr);
        $jsonArray = json_decode($result,true);
        $summary=$jsonArray['summary'];
        return  $summary;
    }

    public  function   searchMovieTitle($movie){
        $UrlSr='https://api.douban.com/v2/movie/search?q='.$movie;
        $result = file_get_contents($UrlSr);
        $jsonArray = json_decode($result,true);
        $title=$jsonArray['title'];
        return $title;
    }
    public  function   searchMovieImage($movie){
        $UrlSr='https://api.douban.com/v2/movie/search?q='.$movie;
        $result = file_get_contents($UrlSr);
        $jsonArray = json_decode($result,true);
        $image_Url=$jsonArray['images']['large'];
        return $image_Url;
    }
    public  function   searchMovieMobileUrl($movie){
        $UrlSr='https://api.douban.com/v2/movie/search?q='.$movie;
        $result = file_get_contents($UrlSr);
        $jsonArray = json_decode($result,true);
        $mobile_url=$jsonArray['mobile_url'];
        return  $mobile_url;
    }



    //响应消息
}
