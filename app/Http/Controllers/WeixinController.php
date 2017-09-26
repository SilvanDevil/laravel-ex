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
//
//    public  function   searchMovieInfo($movies){
//        $UrlSr='https://api.douban.com/v2/movie/search?q='.$movies;
//        $result = file_get_contents($UrlSr);
//        $jsonArray = json_decode($result,true);
//        $id=$jsonArray['subjects'][0]['id'];
//        $UrlSrr='https://api.douban.com/v2/movie/subject/'.$id;
//        $resultr = file_get_contents($UrlSrr);
//        $jsonArray = json_decode($resultr,true);
//        $title=$jsonArray['title'];
//        $summary=$jsonArray['summary'];
//        $image_Url=$jsonArray['images']['large'];
//        $mobile_url=$jsonArray['mobile_url'];
//        $arrayInfo=array($title,$summary,$image_Url,$mobile_url);
//        return $arrayInfo;
//    }

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
           // $msgType = $postObj->MsgType;//消息类型
           // $event = $postObj->Event;//时间类型，subscribe（订阅）、unsubscribe（取消订阅）
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
                           <ArticleCount>1</ArticleCount>
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
                $contentStr = "欢迎关注silvan，目前属于学习测试阶段.\n1.正在热映的电影.\n2.即将上映的电影";
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
                if(preg_match('/[\x{4e00}-\x{9fa5}]+/u',$keyword)){
                     $msgType="news";
                   // $id=$this->searchMovieId($keyword);
//                    $title = $this->searchMovieInfo($keyword)[0];
//                    $desc = $this->searchMovieInfo($keyword)[1];
//                    $picUrl = $this->searchMovieInfo($keyword)[2];
//                    $Url = $this->searchMovieInfo($keyword)[3];
                    $UrlSr='https://api.douban.com/v2/movie/search?q='.$keyword;
                    $result = file_get_contents($UrlSr);
                    $jsonArray = json_decode($result,true);
                    $id=$jsonArray['subjects'][0]['id'];
                    $UrlSrr='https://api.douban.com/v2/movie/subject/'.$id;
                    $resultr = file_get_contents($UrlSrr);
                    $jsonArray = json_decode($resultr,true);
                    $title=$jsonArray['title'];
                    $desc=$jsonArray['summary'];
                    $picUrl=$jsonArray['images']['large'];
                    $Url=$jsonArray['mobile_url'];

                   //$title = "王牌保镖";
                    //$desc = "影片讲述职业杀手（塞缪尔·杰克逊 Samuel L. Jackson 饰）为了解救妻子（萨尔玛·海耶克 Salma Hayek 饰）自愿成为法庭审判一名超级罪犯（加里·奥德曼 Gary Oldman 饰）的关键证人，被警方派重兵护送出庭作证。罪犯为杀人灭口派出 雇佣兵全歼了护送部队。侥幸逃生的女探员（艾洛蒂·袁 Elodie Yung 饰）只能避开警方既定路线请来私人保镖（瑞恩·雷诺兹 Ryan Reynolds 饰）继续护送证人。殊不知二人是多年的死对头，现在却要共同抵抗雇佣兵的截杀和警方的追捕并在24小时之内从英国伦敦抵达荷兰海牙出庭作证。两人冤家聚头火花四溅，为全球观众献上一场爆笑不断的动作大片版“尖峰时刻”";
                  //  $picUrl = 'https://img3.doubanio.com/view/movie_poster_cover/lpst/public/p2498055621.jpg';
                  //  $Url = 'https://movie.douban.com/subject/22266126/mobile';
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
                    if($keyword==1)
                    {
                        $UrlSr='https://api.douban.com/v2/movie/in_theaters?city=重庆';
                        $result = file_get_contents($UrlSr);
                        $jsonArray = json_decode($result,true);
                        $str=null;
                        for($i=0;$i<20;$i++){

                            $str=str.$jsonArray['subjects'][$i]['title']."\n";

                        }
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $str);
                        echo $resultStr;
                    }
                    if($keyword==2)
                    {
                        $UrlSr='https://api.douban.com/v2/movie/coming_soon';
                        $result = file_get_contents($UrlSr);
                        $jsonArray = json_decode($result,true);
                        $str=null;
                        for($i=0;$i<20;$i++){

                            $str=str.$jsonArray['subjects'][$i]['title']."\n";

                        }
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $str);
                        echo $resultStr;
                    }

                    $contentStr = "非常抱歉，没有搜索您的电影！.\n【1】.正在热映的电影,.\n【2】.即将上映的电影\"";
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

//    public  function  searchMovieId($movie){
//        $UrlSr='https://api.douban.com/v2/movie/search?q='.$movie;
//        $result = file_get_contents($UrlSr);
//        $jsonArray = json_decode($result,true);
//        $id=$jsonArray['subjects'][0]['id'];
//        return  $id;
//    }
//
//    public function   searchMovieSummary($id){
//        $UrlSr='https://api.douban.com/v2/movie/subject/'.$id;
//        $result = file_get_contents($UrlSr);
//        $jsonArray = json_decode($result,true);
//        $summary=$jsonArray['summary'];
//        return  $summary;
//    }
//
//    public  function   searchMovieTitle($id){
//        $UrlSr='https://api.douban.com/v2/movie/subject/'.$id;
//        $result = file_get_contents($UrlSr);
//        $jsonArray = json_decode($result,true);
//        $title=$jsonArray['title'];
//        return $title;
//    }
//    public  function   searchMovieImage($id){
//        $UrlSr='https://api.douban.com/v2/movie/subject/'.$id;
//        $result = file_get_contents($UrlSr);
//        $jsonArray = json_decode($result,true);
//        $image_Url=$jsonArray['images']['large'];
//        return $image_Url;
//    }
//    public  function   searchMovieMobileUrl($id){
//        $UrlSr='https://api.douban.com/v2/movie/subject/'.$id;
//        $result = file_get_contents($UrlSr);
//        $jsonArray = json_decode($result,true);
//        $mobile_url=$jsonArray['mobile_url'];
//        return  $mobile_url;
//    }





    //响应消息
}
