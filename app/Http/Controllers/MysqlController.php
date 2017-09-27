<?php


namespace  App\Http\Controllers;
use Illuminate\Support\Facades\DB;
class  MysqlController extends   Controller
{
    public function  test()
    {
        $students = DB::select('select * from student ');
        dd($students);
        //   $students =  DB::insert('insert into student(name,age) values(?,?)',['duanhua',18] );
      //  $students = DB::update('update student set age = ? where  name = ?' ,[20,'duanhua']);
        //$students = DB::delete('delete from student where name = ?',['duanhua']);
        //var_dump($students);
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

    public  function   searchMovieTitle($id){
        $UrlSr='https://api.douban.com/v2/movie/subject/'.$id;
        $result = file_get_contents($UrlSr);
        $jsonArray = json_decode($result,true);
        $title=$jsonArray['title'];
        return $title;
    }
    public  function   searchMovieImage($id){
        $UrlSr='https://api.douban.com/v2/movie/subject/'.$id;
        $result = file_get_contents($UrlSr);
        $jsonArray = json_decode($result,true);
        $image_Url=$jsonArray['images']['large'];
        return $image_Url;
    }
    public  function   searchMovieMobileUrl($id){
        $UrlSr='https://api.douban.com/v2/movie/subject/'.$id;
        $result = file_get_contents($UrlSr);
        $jsonArray = json_decode($result,true);
        $mobile_url=$jsonArray['mobile_url'];
        $image_Url=$jsonArray['images']['large'];
        $a = array($mobile_url,$image_Url);
        return  $a;
    }

    public function  query()
    {   $movie="王牌保镖";
        $UrlSr='https://api.douban.com/v2/movie/search?q='.$movie;
        $url = 'https://api.douban.com/v2/movie/in_theaters?count=10';
        $result = file_get_contents($UrlSr);
        $jsonArray = json_decode($result,true);
        $dh=$jsonArray['subjects'][0]['id'];
        //$ds['title']=$jsonArray['subjects'][0]['title'];

        $url1 = 'https://api.douban.com/v2/movie/subject/25808075';
        $result1 = file_get_contents($url1);
        $jsonArray1 = json_decode($result1,true);
        $b['summary']=$jsonArray1['summary'];
     //var_dump($this->searchMovieId("王牌保镖"));
        $keyword="王牌保镖";
       // print_r(preg_match('/[\x{4e00}-\x{9fa5}]+/u',$keyword));
//        var_dump($keyword);
//        $id=$this->searchMovieId($keyword);
//        $title = $this->searchMovieTitle($id);
//        $desc = $this->searchMovieSummary($id);
//        $picUrl = $this->searchMovieImage($id);
//        $Url = $this->searchMovieMobileUrl($id)[1];

        $title = $this->test($keyword)[0];
        $desc = $this->test($keyword)[1];
        $picUrl = $this->test($keyword)[2];
        $Url = $this->test($keyword)[3];
        $UrlSr='https://api.douban.com/v2/movie/in_theaters?city=重庆';
        $result = file_get_contents($UrlSr);
        $jsonArray = json_decode($result,true);
        $str=null;
        for($i=0;$i<20;$i++){


            $str=$str.$jsonArray['subjects'][$i]['title']."</BR>";


        }
        print_r($str);
//        print_r($id);
//        print_r($title);
//        print_r($desc);
//        print_r($picUrl);
//        print_r($Url);
       // print_r($this->searchMovieSummary($this->searchMovieId("王牌保镖")));
//        for($i=1;$i<=9;$i++){
//
//         //  $dh['title']=;
//          array_push($ds['title'],$jsonArray['subjects'][$i]['title']);
//        }

//        var_dump($b['summary']);
//        var_dump($ds['title']);
//        var_dump($jsonArray['subjects'][1]['images']['large']);
      //  var_dump($jsonArray);
//        $students=DB::table('student')->insert([
//            ['name'=>'duanhua','age'=>18],
//            ['name'=>'zhouwei','age'=>17],
//        ]);
//        var_dump($students);
        //  $students = DB::table('student')->where('name','duanhua')->update(['age'=>100]);
       // $students = DB::table('student')->increment('age',3);
       // $students = DB::table('student')->decrement('age',3);
      //  var_dump($students);

    }

}