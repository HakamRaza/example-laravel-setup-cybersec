<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Profile;
use App\Models\User;
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

Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
    return $request->user();
});


Route::get('/test-log', function (Request $request) {

    Log::channel('stuffs')->info('Date: '.now().', Cron job: SomeEvents'.', Status: Success, user_id: '.random_int(10,90));

    return response()->json([
        "message" =>"log created, go to storage\logs to see the logs"
    ], 200);
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

    return response()->json([
        "message" =>"This is key obtained :".$someKey." ".$someTestKey,
    ], 200);
});


Route::post('/mass-assignable', function (Request $request) {

    $user = Profile::where("id", $request->user_id)->first();

    // mass assignable are called
    $user->update($request->all());

    /**
     * also can be prevented by using only() or except()
     */
    // $user->update($request->except("salary"));
    // $user->update($request->only("created_at"));

    return $user;
});



Route::apiResource('/user', UserController::class);
Route::post('/login', [UserController::class, "login"]);

Route::put('/profile', [ProfileController::class, "update"]);
