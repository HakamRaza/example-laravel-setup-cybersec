<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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


    public function show(Profile $profile)
    {
        /**
         * Implementing policy to prevent unauthorised view
         *
         * This will check policy view of ProfilePolicy for 'view' action
         * If not comply, request is rejected to proceed
         */

        $this->authorize('view', $profile);

        //some logic

        return response()->json([
            "message" =>"Information successfully obtained"
        ], 200);
    }


    public function destroy(Profile $profile)
    {
        $user = $user = User::where("id", 1)->first();

        $hasPermission = $user->hasPermissionTo('delete profile');
        $hasRole = $user->hasRole('admin');

        if( $hasPermission && $hasRole)
        {
            return response()->json([
                "message" =>"You can delete this profile",
            ], 200);
        }

        return response()->json([
            "message" =>"You cannot, booo.",
        ], 403);
    }
}
