<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Add new user with passwords
         *
         * Use one way hash mechanims to password
         * Verified user using hash cross check
         * Dont use MD5 or SHA1 as it is weak
         *
         */
        $password = Hash::make($request->password);
        $request->merge(["password" => $password]);
        $user = User::firstOrCreate($request->all());

        return response()->json([
            "message" =>"user created",
            "data" => $user
        ], 200);
    }

    /**
     * Store a login user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        /**
         * login the registered user
         * check password hash
         */

        $user = User::where('name',$request->name)->first();

        if ($user && Hash::check(
                $request->password,
                $user->password
            ))
        {
            return response()->json([
                "message" =>"login success",
                "token" => Str::random(30)
            ], 200);
        }

        return response()->json([
            "message" =>"login fail",
        ], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //not available yet
    }

    /**
     * Fetch referral history
     *
     */
    public function getReferralTrackingHistory()
    {
    }
}
