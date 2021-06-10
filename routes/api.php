<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\EmployeeController;



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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('employee', [EmployeeController::class,'index']);

Route::post('/login',[UserController::class,'login']);
Route::get('/login',[UserController::class,'login']);


Route::group(['middleware' => 'auth:api'], function() {
    Route::get('companies', [CompanyController::class,'index']);
    Route::get('companies/{id}', [CompanyController::class,'show']);
    Route::post('companies', [CompanyController::class,'store']);
    Route::put('companies/{id}', [CompanyController::class,'update']);
    Route::delete('companies/{id}',[CompanyController::class,'delete']);
});
