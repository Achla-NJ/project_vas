<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Activity;
use App\Models\Company;
use App\Models\User;
use Auth;
use Gate;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
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
    
}
