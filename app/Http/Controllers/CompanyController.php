<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Activity;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;
use Auth;
use Gate;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

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
        
        if(auth()->user()->hasRole('admin')){
            $companies = Company::query()->where(['role_id' => $active_role ])->latest()->get();
        }
        else{
            $companies = Company::query()->where(['user_id'=> auth()->id() , 'role_id' => $active_role ])->latest()->get();
        }
 

        return view('admin.companies.index', compact('companies'));
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
        $company = Company::create($data);

        js_activity_log(auth()->id() , "App\Models\Company" , 'create' , $company->id , $data['role_id'] , js_model_name("App\Models\Company" , $company->id));
        
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
        $company->update($data);

        js_activity_log(auth()->id() ,  "App\Models\Company" , 'update' , $company->id ,$data['role_id'] , js_model_name("App\Models\Company" , $company->id));

        
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

        js_activity_log(auth()->id() ,  "App\Models\Company" , 'delete' , $company->id ,$role_id ,js_model_name("App\Models\Company" , $company->id));
        
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
