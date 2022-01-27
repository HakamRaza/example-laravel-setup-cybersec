<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * Example of using input validation when updating profile
     *
     * @param  \Illuminate\Http\Requests\ProfileUpdateRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpdateRequest $request)
    {
        $profile = Profile::where("user_id", $request->user_id)->first();
        $profile->update($request->all());

        return response()->json([
            "message" =>"Profile updated",
            "data" => $profile
        ], 200);
    }
}
