<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function sample(){
        return view("sample.samplepage", ["name" => "John",  "address" => "Malaysia"]);
    }
}
