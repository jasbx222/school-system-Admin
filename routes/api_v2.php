<?php 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// this route example  version two for this project 


//راوت 
//الاصدار الثاني للمشروع 



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return response()->json('wellcome to v2 ');
});
