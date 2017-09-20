<?php


namespace  App\Http\Controllers;
use Illuminate\Support\Facades\DB;
class  MysqlController extends   Controller
{
    public function  test()
    {
       // $students = DB::select('select * from student ');
        //dd($students);
        //   $students =  DB::insert('insert into student(name,age) values(?,?)',['duanhua',18] );
      //  $students = DB::update('update student set age = ? where  name = ?' ,[20,'duanhua']);
        //$students = DB::delete('delete from student where name = ?',['duanhua']);
        //var_dump($students);
     }

    public function  query()
    {
        $url = 'https://api.douban.com/v2/movie/in_theaters?count=10';
        $result = file_get_contents($url);
        $jsonArray = json_decode($result,true);



        var_dump($jsonArray['subjects'][1]['images']['large']);
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