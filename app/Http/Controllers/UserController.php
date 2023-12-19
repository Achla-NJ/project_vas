<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use Gate;
use App\Models\Activity;
use App\Models\Company;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
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

        $currentMonth = Carbon::now()->format('m'); // Get the current month

        $roles = $user->roles;

        $active_role = session()->get('active_role')['id'];

        if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin')){
            $companies = Company::query()->where(['role_id' => $active_role ])->latest()->limit(10)->get();
            $activities = Activity::query()->where(['role_id' => $active_role ])->latest()->limit(10)->get();

            // Your Eloquent query
            $due_date_companies = Company::query()->where('role_id' , $active_role)->whereMonth('due_date', $currentMonth)
                ->whereYear('due_date', Carbon::now()->year)
                ->orderBy('due_date')->limit(10)
                ->get();
        }
        else{
            $companies = Company::query()->where(['user_id'=> auth()->id() , 'role_id' => $active_role ])->latest()->limit(10)->get();
            $activities = Activity::query()->where(['user_id' => $user->id , 'role_id' => $active_role ])->latest()->latest()->limit(10)->get();
            $due_date_companies = Company::query()->where(['user_id'=> auth()->id() , 'role_id' => $active_role ])->whereMonth('created_at', $currentMonth)
                ->whereYear('due_date', Carbon::now()->year)
                ->orderBy('due_date')
                ->get();
        }


        return view('admin.dashboard.index', compact('roles' , 'companies' ,'activities' , 'due_date_companies'));
    }

    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $active_role = session()->get('active_role')['id'];

        if(auth()->user()->hasRole('super_admin') ){ 
            $users = User::whereHas('userRoles', function ($query) use ($active_role) {
                $query->where('role_id', $active_role);
            })->latest()->get();           
        }

        elseif(auth()->user()->hasRole('admin') ){ 
            $users = User::query()->where('id', '!=' , '1')->whereHas('userRoles', function ($query) use ($active_role) {
                $query->where('role_id', $active_role);
            })->latest()->get();           
        }

        

        // if(auth()->user()->hasRole('super_admin')  || auth()->user()->hasRole('admin')){
        //     if($active_role == '1'){
        //         $users = User::query()->latest()->get();
        //     }else{
        //         $users = User::whereHas('userRoles', function ($query) use ($active_role) {
        //             $query->where('role_id', $active_role);
        //         })->latest()->get();

        //     }
        // }
        else{
            $users = User::query()->where(['id'=> auth()->id() , 'role_id' => $active_role ])->latest()->get();
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
        $roles = Role::query()->where('id' , '!=' ,'1')->latest()->get();

        return view('admin.users.manage',['roles' => $roles,'disp'=>'1']);
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

        
        
        if (in_array('4', $request->role)) {
            $roles = collect(Role::query()->where('id' , '!=' , '1')->get('id'))->pluck('id')->toArray();
        } else { 
            $roles = $request->role;
        }

        $add_user = $user->create(array_merge($request->validated([
            'file' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
        ]), [
            'password' => $request->password ,
            'save_password'=>$request->password,
            'gender'=>$request->gender,
            'added_by' => auth()->id(),
            'role_id' => $active_role,
        ]))->assignRole($roles);

        if($request->hasfile('file')){
            $file =$request->file('file')->store( 'uploads/profile', 'public');
            $add_user->file =$file ;
            $add_user->save();
        }


        js_activity_log(auth()->id() , "App\Models\User" , 'created' , $user->id , $active_role ,js_model_name("App\Models\User" , $add_user->id));


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

        $roles = Role::query()->where('id' , '!=' ,'1')->latest()->get();

        return view('admin.users.manage', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => $roles,'disp'=>'1'
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

        $data = $request->validated([
            'file' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
            'password' => 'nullable|string|min:6',
            'gender' => 'nullable',
        ]);

        $data['save_password'] = $request->password;
        $data['password'] = $request->password;
        $data['gender'] = $data['gender'];

        $data['added_by'] = auth()->id();
        $data['role_id'] = $active_role;
        $user->update($data);


        if($request->hasfile('file')){
            $file =$request->file('file')->store( 'uploads/profile', 'public');
            $user->file =$file ;
            $user->save();
        }


        if(!auth()->user()->hasRole('super_admin')  || auth()->user()->hasRole('admin')){
            if (in_array('4', $request->get('role'))) {
                $roles = collect(Role::query()->where('id' , '!=' , '1')->get('id'))->pluck('id')->toArray();
            } else { 
                $roles = $request->get('role');
            }
            $user->syncRoles($roles);
        }

        js_activity_log(auth()->id() , "App\Models\User" , 'updated' , $user->id , $active_role ,js_model_name("App\Models\User" , $user->id));


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



        $active_role = session()->get('active_role')['id'];

        js_activity_log(auth()->id() , "App\Models\User" , 'deleted' , $user->id , $active_role ,js_model_name("App\Models\User" , $user->id));

        $user->delete();

        return redirect()->route('admin.users.index')
            ->withSuccess(__('User deleted successfully.'));
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activities = Activity::query()->where(['user_id' => $user->id ])->latest()->paginate(8);


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
