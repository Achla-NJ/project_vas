<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        $id = $this->route('company')->id ?? '';
        return [
            'company_name' => 'required|string|max:255',
            'trade_name' => 'required|string|max:255',
            'firm_type' => 'required|string|in:private_limited,llp,sole_proprietorship,one_person_company',
            'registered_address' => 'required|string',
            'gstin_no' => 'required|string|max:20',
            'business_website' => 'nullable|url',
            'director_name' => 'required|string|max:255',
            'aadhar_card_no' => 'required|string|max:20',
            'pan_card_no' => 'required|string|max:20',
            'mobile_no' => 'required|string',
            'email_address' => 'required|email|max:255',
            'local_address' => 'required|string',
            'authorized_person_name' => 'required|string|max:255',
            'contact_no' => 'required|string',
            'authorized_person_aadhar' => 'required|string|max:20',
            'authorized_person_pan' => 'required|string|max:20',
            'sales_type' => 'required|string|in:b2b,b2c',
            'aggregator_name' => 'nullable|string|max:255',
            'employee_name' => 'nullable|string|max:255',
            'due_date' => 'nullable',
            'user_id' => 'nullable',
            'role_id' => 'nullable',
            'gst_file'=> $id ? "nullable|mimes:jpeg,jpg,png" : 'required|mimes:jpeg,jpg,png',
            'aadhar_card_file'=> $id ? "nullable|mimes:jpeg,jpg,png" : 'required|mimes:jpeg,jpg,png',
            'pan_card_file'=> $id ? "nullable|mimes:jpeg,jpg,png" : 'required|mimes:jpeg,jpg,png', 
        ];
    }
}
 