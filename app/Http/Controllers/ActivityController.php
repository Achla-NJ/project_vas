<?php

namespace App\Http\Controllers;

use App\Models\Activity; 

use Illuminate\Http\Request; 
use Gate;
use Auth;
use Illuminate\Http\Response;
class ActivityController extends Controller
{

    public function index() 
    {
        abort_if(Gate::denies('history'), Response::HTTP_FORBIDDEN, '403 Forbidden');
 
        $user = Auth::user();
 
        $role_id = session()->get('active_role')['id'];

        if($role_id ==1){
            $activities = Activity::query()->latest()->get();
        }else{
            $activities = Activity::query()->where(['user_id' => $user->id , 'role_id' => $role_id ])->latest()->get();
        }

        
 
        return view('admin.history.index', compact('activities'));
    }
}