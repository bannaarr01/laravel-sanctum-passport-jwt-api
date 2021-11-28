<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("list-employees", [ApiController::class, "listEmployees"]);
Route::get("single-employee/{id}", [ApiController::class, "getSingleEmployee"]);
Route::post("add-employee", [ApiController::class, "createEmployee"]);
Route::put("update-employee/{id}", [ApiController::class, "updateEmployee"]);
Route::delete("delete-employee/{id}", [ApiController::class, "deleteEmployee"]);
