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
            'company_name' => 'required|max:255',
            'trade_name' => 'nullable|max:255',
            'firm_type' => 'nullable|in:private_limited,llp,sole_proprietorship,one_person_company',
            'registered_address' => 'nullable',
            'gstin_no' => 'nullable',
            'business_website' => 'nullable',
            'industry' => 'nullable|max:255',
            'industry_field' => 'nullable|max:255',
            'property_type' => 'nullable|max:255',
            'director_name' => 'nullable|max:255',
            'aadhar_card_no' => 'nullable',
            'pan_card_no' => 'nullable',
            'mobile_no' => 'required',
            'email_address' => 'nullable|max:255',
            'local_address' => 'nullable',
            'authorized_person_name' => 'nullable|max:255',
            'contact_no' => 'nullable',
            'authorized_person_aadhar' => 'nullable',
            'authorized_person_pan' => 'nullable',
            'sales_type' => 'nullable|in:b2b,b2c,workspace-partners',
            'aggregator_name' => 'nullable|max:255',
            'employee_name' => 'nullable|max:255',
            'due_date' => 'nullable',
            'user_id' => 'nullable',
            'role_id' => 'nullable',
            'gst_file'=> 'nullable',
            'aadhar_card_file'=> "nullable",
            'pan_card_file'=> "nullable",
            'authorized_person_aadhar_file'=> "nullable",
            'authorized_person_pan_file'=> "nullable",
            'work_agreement'=> "nullable",
            'electricity_bill'=>"nullable",
            'agreement'=> "nullable",
            'private_bill'=> "nullable",
            'property_tax_receipt'=> "nullable",
            'municipal_khata'=> "nullable",
        ];
    }
}
