<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'client_id' => 'nullable',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'nullable',
            'estimate_time' => 'required',
            'estimate_type' => 'required',
            'users' => 'required',
            'status'=>'required'
        ];
    }
}
 