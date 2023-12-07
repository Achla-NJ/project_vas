<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        // Let's get the route param by name to get the User object value
        $user = request()->route('user');

        return [
            'name' => 'required',
            'gender' => 'required',
            'job_title' => 'required',
            'date_of_hire' => 'required',
            'salary' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email,'.$user->id,
            'mobile' => 'required|unique:users,mobile,'.$user->id,
            'department_id' => 'required_if:role,==,user',
        ];
    }
}