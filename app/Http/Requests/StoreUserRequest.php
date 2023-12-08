<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required',
            'gender' => 'required',
            'job_title' => 'required',
            'date_of_hire' => 'required',
            'salary' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'mobile' => 'required|unique:users,mobile',
            
        ];
    }
}
 