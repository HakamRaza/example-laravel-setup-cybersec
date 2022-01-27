<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            /**
             *
             * Validate input for:
             * 1. size or character length or value (min max char, bytes, less than 10, whitelist, blacklist)
             * 2. data types or file types (string, integer, array, object, mime: jpg, pdf, ...)
             * 3. correct format (date, time, has special characters, dash, uppercase, ...)
             *
             */
            'user_id' => 'sometimes|required|exists:users,id',
            'salary' => 'sometimes|required|integer|between:1000,10000'
        ];
    }
}
