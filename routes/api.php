<?php

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

Route::post('map',function(Request $req){
   $db= new \App\Helpers\FileDBHelper();
   $db->initRows();

   if(!empty($req->filter['gender'])){
       $db->filterGender($req->filter['gender']);
   }

   if(!empty($req->filter['city'])){
       $db->filterCoordinates($req->filter['city']);

   }

   if(!empty($req->filter['txt'])){
       $db->filterNameOrFamily($req->filter['txt']);
   }

   return response()->json(['data'=>$db->all()]);
})->name('map');
