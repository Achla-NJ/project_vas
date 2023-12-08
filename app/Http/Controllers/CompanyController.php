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

        $companies = Company::latest()->get();

        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show form for creating user
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('company_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.companies.manage', ['clients' => User::role('client')->get(), 'users' => User::role('user')->get(), 'disp' => '1']);

    }

    /**
     * Store a newly created user
     *
     * @param Company $project
     * @param CompanyRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        abort_if(Gate::denies('company_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validated();
        $data['users'] = "";
        $project = Company::create($data);

        Activity::create([
            'name' => $project->name,
            'user_id' => Auth::user()->id,
            'log_type' => 'project',
            'activity' => 'added',
            'log_id' => $project->id,
        ]);
        foreach ($request->users as $user) {
            CompanyUser::create(['user_id' => $user, 'project_id' => $project->id]);
        }

        return redirect()->route('admin.companies.index')
            ->withSuccess(__('Company created successfully.'));

    }
    /**
     * Edit user data
     *
     * @param Company $project
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $project)
    {
        abort_if(Gate::denies('company_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.companies.manage', [
            'project' => $project,
            'clients' => User::role('client')->get(), 'users' => User::role('user')->get(),
            'project_users' => CompanyUser::where('project_id', $project->id)->get(), 'disp' => '1',
        ]);

    }

    /**
     * Update user data
     *
     * @param Company $project
     * @param CompanyRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Company $project, CompanyRequest $request)
    {
        abort_if(Gate::denies('company_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        CompanyUser::where('project_id', $project->id)->delete();
        $project->update($request->validated());

        Activity::create([
            'name' => $project->name,
            'user_id' => Auth::user()->id,
            'log_type' => 'project',
            'activity' => 'updated',
            'log_id' => $project->id,
            'updation' => json_encode($project->getChanges()),
        ]);

        foreach ($request->users as $user) {
            CompanyUser::create(['user_id' => $user, 'project_id' => $project->id]);
        }
        return redirect()->route('admin.companies.index')
            ->withSuccess(__('Company updated successfully.'));

    }

    /**
     * Delete user data
     *
     * @param Company $project
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $project)
    {
        abort_if(Gate::denies('company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project->delete();

        return redirect()->route('admin.companies.index')
            ->withSuccess(__('Company deleted successfully.'));

    }

    public function show(Company $project)
    {
        abort_if(Gate::denies('company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.companies.manage', [
            'project' => $project,
            'clients' => User::role('client')->get(), 'users' => User::role('user')->get(),
            'project_users' => CompanyUser::where('project_id', $project->id)->get(), 'disp' => '0',
        ]);
    }

    public function getCompanyUser(Request $request)
    {
        $html = "<option value='0'>-Select-</option>";
        $project_users = CompanyUser::where('project_id', $request->project_id)->get();
        foreach ($project_users as $project_user) {
            $user = User::find($project_user->user_id);
            $html .= "<option value='$user->id'>$user->name</option>";
        }
        return \Response::json(['status' => true, 'data' => $html]);
    }
}
