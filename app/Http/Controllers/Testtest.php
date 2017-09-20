<?php

namespace  App\Http\Controllers;

class Testtest extends  Controller
{


    public function info($id)
    {

        return  view('test/test',['test1'=>'123456','test2'=>'abcdef']);

    }
}



