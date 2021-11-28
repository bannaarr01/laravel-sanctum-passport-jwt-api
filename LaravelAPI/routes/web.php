<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("sample", [TestController::class, "sample"]);
//Route::prefix("admin")->group(function (){
//    //same as below
//});
//
//Route::group(["prefix" => "admin"], function (){
//
//});

//Name of middleware = first, second
//Route::group(["middleware" => "first", "second"], function (){
////..
//    Route::get("create-user", [TestController::class, "createUser"]);
//    Route::get("list-users", [TestController::class, "listUsers"]);
//    Route::get("edit-user", [TestController::class, "editUser"]);
//});

//Route::middleware(["first", "second"])->group(function (){
////..
//    Route::get("create-user", [TestController::class, "createUser"]);
//    Route::get("list-users", [TestController::class, "listUsers"]);
//    Route::get("edit-user", [TestController::class, "editUser"]);
//});
