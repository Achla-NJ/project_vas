<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use Gate;
use App\Models\Activity;
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

        $active_role = session()->get('active_role')['id']; 
 
        if(auth()->user()->hasRole('admin')){
            if($active_role == '1'){
                $users = User::query()->latest()->get();
            }else{   
                $users = User::whereHas('userRoles', function ($query) use ($active_role) {
                    $query->where('role_id', $active_role);
                })->latest()->get(); 
 
            }            
        }
        else{
            $users = User::query()->where(['user_id'=> auth()->id() , 'role_id' => $active_role ])->latest()->get();
        }
        
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
        
        $active_role = session()->get('active_role')['id']; 

        $user->create(array_merge($request->validated(), [
            'password' => $request->password ,
            'save_password'=>$request->password,
            'gender'=>$request->gender,
            'added_by' => auth()->id(),
            'role_id' => $active_role,
        ]))->assignRole($request->role);

       

        js_activity_log(auth()->id() , "App\Models\User" , 'create' , $user->id , $active_role);

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
        
        $active_role = session()->get('active_role')['id']; 

        $data = $request->validated();
        $data['save_password'] = $request->password;
        $data['added_by'] = auth()->id();
        $data['role_id'] = $active_role;
        $user->update($data);

        $user->syncRoles($request->get('role'));

        js_activity_log(auth()->id() , "App\Models\User" , 'update' , $user->id , $active_role);
        

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

        $active_role = session()->get('active_role')['id']; 

        js_activity_log(auth()->id() , "App\Models\User" , 'delete' , $user->id , $active_role);

        return redirect()->route('admin.users.index')
            ->withSuccess(__('User deleted successfully.'));
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activities = Activity::query()->where(['user_id' => $user->id ])->latest()->get();


        return view('admin.users.manage', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get(),'disp'=>'0' , 
            'activities' => $activities
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

    public function profile(Request $request) 
    {
        abort_if(Gate::denies('profile'), Response::HTTP_FORBIDDEN, '403 Forbidden');
   
        $user = auth()->user();

        return view('admin.users.profile', compact('user'));
    }

    public function updateProfile(Request $request) 
    {
        abort_if(Gate::denies('profile'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        
        $data = $request->validate([
            'file' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
        ]);
        
        $user = User::find(auth()->id());

        if($request->hasfile('file')){
            $file =$request->file('file')->store( 'uploads/profile', 'public');
            $user->file =$file ;
            $user->save();
        }
        

        return redirect()->route('admin.profile')->withSuccess('Profile Updated successfully.');
    }
}