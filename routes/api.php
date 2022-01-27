<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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


Route::get('/test-log', function (Request $request) {

    Log::channel('stuffs')->info('Date: '.now().', Cron job: SomeEvents'.', Status: Success, user_id: '.random_int(10,90));

    return $request->user();
});


Route::get('/test-key', function (Request $request) {

    /**
     * Retrieve key from env this way
     */
    $someKey = config("services.testservice.key");
    $someTestKey = config("services.testservice.test_key");

    /**
     * NOT this way
     */
    // $someKey = env("IMPORTANT_KEY");
    // $someTestKey = env("TEST_IMPORTANT_KEY");

    return "This is key obtained :".$someKey." ".$someTestKey;
});



Route::middleware('auth:sanctum')->apiResource('/user', UserController::class);
