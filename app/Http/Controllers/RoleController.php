<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Auth;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        // $roles = Role::whereNotIn('name', ['admin'])->get();
        $roles = Role::all();
        return view('admin.roles.index',compact('roles'));
        
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('add_role')){
            $permissions = Permission::get();
            return view('admin.roles.manage', compact('permissions'));
        }
        return abort(401, 'Unauthorized');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('add_project')){
            $this->validate($request, [
                'name' => 'required|unique:roles,name',
                'permission' => 'required',
            ]);
        
            $role = Role::create(['name' => $request->get('name')]);
            $role->syncPermissions($request->get('permission'));
        
            return redirect()->route('admin.roles.index')
                            ->with('success','Role created successfully');
        }
        return abort(401, 'Unauthorized');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $role = $role;
        $rolePermissions = $role->permissions;
    
        return view('admin.roles.show', compact('role', 'rolePermissions'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if(Auth::user()->can('edit_role')){
            $role = $role;
            $rolePermissions = $role->permissions->pluck('name')->toArray();
            $permissions = Permission::get();
        
            return view('admin.roles.manage', compact('role', 'rolePermissions', 'permissions'));
        }
        return abort(401, 'Unauthorized');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Role $role, Request $request)
    {
        if(Auth::user()->can('edit_role')){
            $this->validate($request, [
                'name' => 'required|unique:roles,name,'.$role->id,
                'permission' => 'required',
            ]);
            
            $role->update($request->only('name'));
        
            $role->syncPermissions($request->get('permission'));
        
            return redirect()->route('admin.roles.index')
                            ->with('success','Role updated successfully');
        }
        return abort(401, 'Unauthorized');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('admin.roles.index')
                        ->with('success','Role deleted successfully');
        
        return abort(401, 'Unauthorized');
    }
}