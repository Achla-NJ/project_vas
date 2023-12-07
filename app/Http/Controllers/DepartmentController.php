<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\TaskStatus;
use Auth;
use App\Http\Requests\DepartmentRequest;
class DepartmentController extends Controller
{
    /**
     * Display all departments
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $departments = Department::latest()->get();

        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        if(Auth::user()->can('add_department')){
            return view('admin.departments.manage',['disp'=>'1','task_statuses'=>TaskStatus::all()]);
        }
        return abort(401, 'Unauthorized');
    }

    /**
     * Store a newly created user
     * 
     * @param Department $department
     * @param DepartmentRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request) 
    {
        if(Auth::user()->can('add_department')){
            $data = $request->validated();
            $data['status'] = json_encode($request->status);
            Department::create($data);
            
            return redirect()->route('admin.departments.index')
                ->withSuccess(__('Department created successfully.'));
        }
        return abort(401, 'Unauthorized');
    }
    /**
     * Edit user data
     * 
     * @param Department $department
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department) 
    {
        if(Auth::user()->can('edit_department')){
            return view('admin.departments.manage', [
                'department' => $department,'disp'=>'1',
                'task_statuses'=>TaskStatus::all()
            ]);
        }
        return abort(401, 'Unauthorized');
        
    }

    /**
     * Update user data
     * 
     * @param Department $department
     * @param DepartmentRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Department $department, DepartmentRequest $request) 
    {
        if(Auth::user()->can('edit_department')){
            $department->update($request->validated());
            return redirect()->route('admin.departments.index')
                ->withSuccess(__('Department updated successfully.'));
        }
        return abort(401, 'Unauthorized');
    }

    /**
     * Delete user data
     * 
     * @param Department $department
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department) 
    {
        if(Auth::user()->can('delete_department')){
            $department->delete();

            return redirect()->route('admin.departments.index')
                ->withSuccess(__('Department deleted successfully.'));
        }
        return abort(401, 'Unauthorized');
    }

    public function show(Department $department)
    {
        return view('admin.departments.manage', [
            'department' => $department,'disp'=>'0'
        ]);
    }
}