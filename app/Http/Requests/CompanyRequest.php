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
            'company_name' => 'required|nullable',
            'trade_name' => 'nullable|max:255',
            'firm_type' => 'nullable|in:private_limited,llp,sole_proprietorship,one_person_company',
            'registered_address' => 'nullable',
            'gstin_no' => 'nullable|max:20',
            'business_website' => 'nullable|url',
            'industry' => 'nullable|max:255',
            'industry_field' => 'nullable|max:255',
            'property_type' => 'nullable|max:255',
            'director_name' => 'nullable|max:255',
            'aadhar_card_no' => 'nullable|max:20',
            'pan_card_no' => 'nullable|max:20',
            'mobile_no' => 'string',
            'email_address' => 'nullable|max:255',
            'local_address' => 'nullable',
            'authorized_person_name' => 'nullable|max:255',
            'contact_no' => 'nullable',
            'authorized_person_aadhar' => 'nullable|max:20',
            'authorized_person_pan' => 'nullable|max:20',
            'sales_type' => 'nullable|in:b2b,b2c,workspace-partners',
            'aggregator_name' => 'nullable|max:255',
            'employee_name' => 'nullable|max:255',
            'due_date' => 'nullable',
            'user_id' => 'nullable',
            'role_id' => 'nullable',
            'gst_file'=> $id ? "nullable|mimes:jpeg,jpg,png,doc,pdf,docx" : 'mimes:jpeg,jpg,png,doc,pdf,docx',
            'aadhar_card_file'=> $id ? "nullable|mimes:jpeg,jpg,png,doc,pdf,docx" : 'mimes:jpeg,jpg,png,doc,pdf,docx',
            'pan_card_file'=> $id ? "nullable|mimes:jpeg,jpg,png,doc,pdf,docx" : 'mimes:jpeg,jpg,png,doc,pdf,docx',
            'authorized_person_aadhar_file'=> $id ? "nullable|mimes:jpeg,jpg,png,doc,pdf,docx" : 'mimes:jpeg,jpg,png,doc,pdf,docx',
            'authorized_person_pan_file'=> $id ? "nullable|mimes:jpeg,jpg,png,doc,pdf,docx" : 'mimes:jpeg,jpg,png,doc,pdf,docx',
            'work_agreement'=> $id ? "nullable|mimes:jpeg,jpg,png,doc,pdf,docx" : 'mimes:jpeg,jpg,png,doc,pdf,docx',
            'electricity_bill'=> $id ? "nullable|mimes:jpeg,jpg,png,doc,pdf,docx" : 'mimes:jpeg,jpg,png,doc,pdf,docx',
            'agreement'=> $id ? "nullable|mimes:jpeg,jpg,png,doc,pdf,docx" : 'mimes:jpeg,jpg,png,doc,pdf,docx',
            'private_bill'=> $id ? "nullable|mimes:jpeg,jpg,png,doc,pdf,docx" : 'mimes:jpeg,jpg,png,doc,pdf,docx',
            'property_tax_receipt'=> $id ? "nullable|mimes:jpeg,jpg,png,doc,pdf,docx" : 'mimes:jpeg,jpg,png,doc,pdf,docx',
            'municipal_khata'=> $id ? "nullable|mimes:jpeg,jpg,png,doc,pdf,docx" : 'mimes:jpeg,jpg,png,doc,pdf,docx',
        ];
    }
}
