<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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


Route::post('/raw-query', function (Request $request)
{
    $id = $request->id;

    /**
     * In the select() method DB, it alreay using PDO in the backgroud which
     * bind parameter and sanitize bind variables. Here 2 methods syntax can be
     * use.
     */

    // 1. positional binding
    $secureRawA = DB::select(DB::raw("
        SELECT COUNT(id) AS TOTAL
        FROM users
        WHERE id = ?
    ",[$id]));

    // 2. positional binding
    $secureRawB = DB::select(DB::raw("
        SELECT COUNT(id) AS TOTAL
        FROM users
        WHERE id = :thisId
    ",[":thisId" => $id ]));

    // 3. another method further can sanitize the input format using sprintf
    // or even better if you can add validation to request which specific data type and value
    // https://www.php.net/manual/en/function.sprintf.php
    $secureRawC = DB::select(DB::raw(sprintf("
        SELECT COUNT(id) AS TOTAL
        FROM users
        WHERE id = %d
    ", $id )));

    /**
     * INSECURE
     * INSECURE
     *
     * This is directly concatenate to query in which skip PDO
     * parameter provided by DB:select()
     */
    $insecureRaw = DB::select(DB::raw("
        SELECT COUNT(id) AS TOTAL
        FROM users
        WHERE id = $id
    "));


    return response()->json([
        "message" => "Raw query"
    ], 200);
});




Route::apiResource('/user', UserController::class);
Route::post('/login', [UserController::class, "login"]);

Route::put('/profile', [ProfileController::class, "update"]);
Route::get('/profile/{profile}', [ProfileController::class, "show"]);

Route::put('/user/{user}', [UserController::class, "update"])->middleware('auth:sanctum');
Route::delete('/profile/{profile}', [ProfileController::class, "destroy"])->middleware(['auth:sanctum']);
