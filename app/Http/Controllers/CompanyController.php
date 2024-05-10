<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Activity;
use App\Models\Company;
use App\Models\User;
use App\Models\OtpVerification;
use Auth;
use Gate;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
class CompanyController extends Controller
{
    /**
     * Display all companies
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('company_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $active_role = session()->get('active_role')['id'];
         // Retrieve users with the specified role
        $users = User::whereHas('roles', function ($query) use ($active_role) {
            $query->where('id', $active_role);
        })->get();

        $companies = Company::query();

        if(auth()->user()->hasRole('admin')){
            if(request('user_id') && !empty(request('user_id'))){
                $companies = $companies->where('user_id' , request('user_id'));
            }else{
                $companies = $companies->where('role_id' , $active_role);
            }
        }
        else{
            $companies = $companies->where(['user_id'=> auth()->id() , 'role_id' => $active_role ]);
        }

        if(request('date_range') && !empty(request('date_range'))){
            $dateRange = request('date_range');
            [$startDate, $endDate] = explode(' to ', $dateRange);

        // Parse the dates using Carbon for easy manipulation
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();

            $companies = $companies->whereBetween('due_date', [$startDate, $endDate]);

        }

        if(request('search') && !empty(request('search'))){
            // $companies = $companies->where('company_name', 'like', '%' . request('search') . '%')
            // ->orWhere('firm_type', 'like', '%' . request('search') . '%');
            $companies = $companies->where(function ($query) {
                $searchTerm = request('search');
                $firm_type = str_replace(' ' ,'_',$searchTerm);

                $query->where('company_name', 'like', '%'.$searchTerm.'%')
                      ->orWhere('firm_type', 'like', '%'.$firm_type.'%');
            });
        }

        if(request('property_type') && !empty(request('property_type'))){
            $propertyType = request('property_type');
            $companies = $companies->where('property_type', $propertyType);
        }

        $companies = $companies->latest()->get();

        return view('admin.companies.index', compact('companies' , 'users'));
    }

    /**
     * Show form for creating user
     *
     * @return \Illuminate\Http\Response
     */

    public function register()
    {
        abort_if(Gate::denies('company_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.companies.register', ['disp' => '1']);

    }

    public function create()
    {
        abort_if(Gate::denies('company_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.companies.manage', ['disp' => '1']);

    }

    /**
     * Store a newly created user
     *
     * @param Company $company
     * @param CompanyRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        abort_if(Gate::denies('company_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['role_id'] = session()->get('active_role')['id'];

        if($request->hasfile('gst_file')){
            $file =$request->file('gst_file')->store( 'uploads/documents', 'public');
            $data['gst_file'] = $file;
        }

        if($request->hasfile('aadhar_card_file')){
            $file =$request->file('aadhar_card_file')->store( 'uploads/documents', 'public');
            $data['aadhar_card_file'] = $file;
        }

        if($request->hasfile('pan_card_file')){
            $file =$request->file('pan_card_file')->store( 'uploads/documents', 'public');
            $data['pan_card_file'] = $file;
        }


        if($request->hasfile('authorized_person_aadhar_file')){
            $file =$request->file('authorized_person_aadhar_file')->store( 'uploads/documents', 'public');
            $data['authorized_person_aadhar_file'] = $file;
        }

        if($request->hasfile('authorized_person_pan_file')){
            $file =$request->file('authorized_person_pan_file')->store( 'uploads/documents', 'public');
            $data['authorized_person_pan_file'] = $file;
        }

        if($request->hasfile('work_agreement')){
            $file =$request->file('work_agreement')->store( 'uploads/documents', 'public');
            $data['work_agreement'] = $file;
        }

        if($request->hasfile('electricity_bill')){
            $file =$request->file('electricity_bill')->store( 'uploads/documents', 'public');
            $data['electricity_bill'] = $file;
        }

        if($request->hasfile('agreement')){
            $file =$request->file('agreement')->store( 'uploads/documents', 'public');
            $data['agreement'] = $file;
        }

        if($request->hasfile('private_bill')){
            $file =$request->file('private_bill')->store( 'uploads/documents', 'public');
            $data['private_bill'] = $file;
        }

        if($request->hasfile('property_tax_receipt')){
            $file =$request->file('property_tax_receipt')->store( 'uploads/documents', 'public');
            $data['property_tax_receipt'] = $file;
        }

        if($request->hasfile('municipal_khata')){
            $file =$request->file('municipal_khata')->store( 'uploads/documents', 'public');
            $data['municipal_khata'] = $file;
        }

        $company = Company::create($data);

        js_activity_log(auth()->id() , "App\Models\Company" , 'created' , $company->id , $data['role_id'] , js_model_name("App\Models\Company" , $company->id));

        return redirect()->route('admin.companies.index')
            ->withSuccess(__('Company created successfully.'));

    }
    /**
     * Edit user data
     *
     * @param Company $company
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        abort_if(Gate::denies('company_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $disp =1;
        return view('admin.companies.manage', compact('company' , 'disp'));

    }

    /**
     * Update user data
     *
     * @param Company $company
     * @param CompanyRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Company $company, CompanyRequest $request)
    {
        abort_if(Gate::denies('company_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['role_id'] = session()->get('active_role')['id'];

        if($request->hasfile('gst_file')){
            $file =$request->file('gst_file')->store( 'uploads/documents', 'public');
            $data['gst_file'] = $file;
        }

        if($request->hasfile('aadhar_card_file')){
            $file =$request->file('aadhar_card_file')->store( 'uploads/documents', 'public');
            $data['aadhar_card_file'] = $file;
        }

        if($request->hasfile('pan_card_file')){
            $file =$request->file('pan_card_file')->store( 'uploads/documents', 'public');
            $data['pan_card_file'] = $file;
        }

        if($request->hasfile('authorized_person_aadhar_file')){
            $file =$request->file('authorized_person_aadhar_file')->store( 'uploads/documents', 'public');
            $data['authorized_person_aadhar_file'] = $file;
        }

        if($request->hasfile('authorized_person_pan_file')){
            $file =$request->file('authorized_person_pan_file')->store( 'uploads/documents', 'public');
            $data['authorized_person_pan_file'] = $file;
        }

        if($request->hasfile('work_agreement')){
            $file =$request->file('work_agreement')->store( 'uploads/documents', 'public');
            $data['work_agreement'] = $file;
        }

        if($request->hasfile('electricity_bill')){
            $file =$request->file('electricity_bill')->store( 'uploads/documents', 'public');
            $data['electricity_bill'] = $file;
        }

        if($request->hasfile('agreement')){
            $file =$request->file('agreement')->store( 'uploads/documents', 'public');
            $data['agreement'] = $file;
        }

        if($request->hasfile('private_bill')){
            $file =$request->file('private_bill')->store( 'uploads/documents', 'public');
            $data['private_bill'] = $file;
        }

        if($request->hasfile('property_tax_receipt')){
            $file =$request->file('property_tax_receipt')->store( 'uploads/documents', 'public');
            $data['property_tax_receipt'] = $file;
        }

        if($request->hasfile('municipal_khata')){
            $file =$request->file('municipal_khata')->store( 'uploads/documents', 'public');
            $data['municipal_khata'] = $file;
        }


        $company->update($data);

        js_activity_log(auth()->id() ,  "App\Models\Company" , 'updated' , $company->id ,$data['role_id'] , js_model_name("App\Models\Company" , $company->id));


        return redirect()->route('admin.companies.index')
            ->withSuccess(__('Company updated successfully.'));

    }

    /**
     * Delete user data
     *
     * @param Company $company
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        abort_if(Gate::denies('company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role_id  = $company->role_id;

        js_activity_log(auth()->id() ,  "App\Models\Company" , 'deleted' , $company->id ,$role_id ,js_model_name("App\Models\Company" , $company->id));

        $company->delete();


        return redirect()->route('admin.companies.index')
            ->withSuccess(__('Company deleted successfully.'));

    }

    public function show(Company $company)
    {
        abort_if(Gate::denies('company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.companies.manage', compact('company'));
    }

    public function sendCompanyOTP(Request $request)
    {
        // Validate incoming request data
        $data = $request->validate([
            'phone_number' => 'required|string',
        ]);

        // Generate OTP
        $otp = mt_rand(100000, 999999);
        // $apiKey = env('MTALKZ_API_KEY');
        // $senderId = env('MTALKZ_SENDER_ID');
        $response = Http::post('https://msgn.mtalkz.com/api', [
            'apikey' => "ejJEAleYwg0Qf4rZ",
            'message' => 'Welcome to VSELEK. Your OTP is ' . $otp . '. Thank you for choosing us. For any assistance, feel free to contact us.',
            'senderid' => "VSELEK",
            'number' => $data['phone_number'],
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            // Check if the response indicates success based on your API's structure
            if ($responseData['status'] === 'OK') {
                // Save OTP details in the database
                $otpDetail = new OtpVerification();
                $otpDetail->phone_number = $data['phone_number'];
                $otpDetail->otp = $otp;
                $otpDetail->save();

                return response()->json(['message' => 'OTP sent successfully'], 200);
            } else {
                return response()->json(['message' => 'Failed to send OTP via mTalks API: ' . $responseData['message']], 500);
            }
        } else {
            return response()->json(['message' => 'Failed to send OTP via mTalks API'], $response->status());
        }
    }

    public function verifyCompanyOTP(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'phone_number' => 'required|string',
            'otp' => 'required|string',
        ]);

        // Check if OTP matches
        $otpDetail = OtpVerification::where('phone_number', $validatedData['phone_number'])
            ->where('otp', $validatedData['otp'])
            ->first();

        if ($otpDetail) {
            $otpDetail->update(['verified' => 'yes']);
            return response()->json(['message' => 'OTP verified successfully'], 200);
        } else {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }
    }

    public function filterData(Request $request) {
        if(request('property_type') && !empty(request('property_type'))){
            // $companies = $companies->where('company_name', 'like', '%' . request('search') . '%')
            // ->orWhere('firm_type', 'like', '%' . request('search') . '%');
            $companies = $companies->where(function ($query) {
                $searchTerm = request('property_type');
                $firm_type = str_replace(' ' ,'_',$searchTerm);

                $query->where('property_type', 'like', '%'.$searchTerm.'%');
            });
        }

        $companies = $companies->latest()->get();

        return view('admin.companies.index', compact('companies'));
    }

}
