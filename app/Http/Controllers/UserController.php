<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use Gate;
use Auth;
use Illuminate\Http\Response;
class UserController extends Controller
{
    /**
     * Display all users
     * 
     * @return \Illuminate\Http\Response
     */
    public function dashboard() 
    {
        abort_if(Gate::denies('dashboard'), Response::HTTP_FORBIDDEN, '403 Forbidden');
 
        $user = Auth::user();
 
        $roles = $user->roles;
 
        return view('admin.dashboard.index', compact('roles'));
    }

    public function index() 
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $users = User::latest()->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.users.manage',['roles' => Role::latest()->get(),'disp'=>'1']);
    }

    /**
     * Store a newly created user
     * 
     * @param User $user
     * @param UserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, UserRequest $request) 
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $user->create(array_merge($request->validated(), [
            'password' => $request->password 
        ]))->assignRole($request->role);

        return redirect()->route('admin.users.index')
            ->withSuccess(__('User created successfully.'));
    }
    /**
     * Edit user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) 
    {
        abort_if(Gate::denies('user_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.users.manage', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get(),'disp'=>'1'
        ]);
    }

    /**
     * Update user data
     * 
     * @param User $user
     * @param UserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UserRequest $request) 
    {
        abort_if(Gate::denies('user_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        
        $user->update($request->validated());

        $user->syncRoles($request->get('role'));

        return redirect()->route('admin.users.index')
            ->withSuccess(__('User updated successfully.'));
    }

    /**
     * Delete user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) 
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return redirect()->route('admin.users.index')
            ->withSuccess(__('User deleted successfully.'));
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        return view('admin.users.manage', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get(),'disp'=>'0'
        ]);
    }

    public function getUser($type)
    {
        $users = User::role($type)->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    public function switch($role) 
    {
        abort_if(Gate::denies('dashboard'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $active_role = Role::query()->where('slug' , $role)->first();

        session()->put('active_role' ,$active_role);

        return redirect()->route('admin.dashboard');
    }
}