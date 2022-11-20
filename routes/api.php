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

//API route for register new user
Route::post('/register', [AuthController::class, 'register']);
//API route for login user
Route::post('/login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum']], function () {

//mendapatkan semua jenis route api/resource dari Pasien controller dan model
Route::apiResource('pasien', PasienController::class);

//mendapatkan semua jenis route api/resource dari statuses controller dan model
Route::apiResource('status', StatusController::class);


//route pencarian nama
Route::get('/search/{request}', [PasienController::class, 'searchByName']);

//route pencarian positive covid
Route::get('/positive', [PasienController::class, 'searchByPositive']);

//route pencarian recovery
Route::get('/recovered', [PasienController::class, 'searchByRecovered']);

//route pencarian kematian akibat covid
Route::get('/dead', [PasienController::class, 'searchByDead']);

});