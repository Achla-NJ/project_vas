<?php

namespace App\Http\Controllers;

use App\Models\Activity; 

use Illuminate\Http\Request; 
use Gate;
use Auth;
use App\Models\User;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Response;
class ActivityController extends Controller
{

    public function index() 
    {
        abort_if(Gate::denies('history'), Response::HTTP_FORBIDDEN, '403 Forbidden');
         ///////

        $active_role = session()->get('active_role')['id'];   
        
         // Retrieve users with the specified role
        $users = User::whereHas('roles', function ($query) use ($active_role) {
            $query->where('id', $active_role);
        })->get();
 
        $activities = Activity::query();
        
        if(auth()->user()->hasRole('super_admin')){
            if(request('user_id') && !empty(request('user_id'))){
                $activities = $activities->where('user_id' , request('user_id'));
            }          
        }
        else{
            $activities = $activities->where(['user_id'=> auth()->id() , 'role_id' => $active_role ]);
        }

        if(request('date_range') && !empty(request('date_range'))){
            $dateRange = request('date_range');
            [$startDate, $endDate] = explode(' to ', $dateRange);

        // Parse the dates using Carbon for easy manipulation
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();

            $activities = $activities->whereBetween('created_at', [$startDate, $endDate]);
            
        } 
        $activities = $activities->latest()->paginate(10);

        return view('admin.history.index', compact('activities', 'users'));
    }
}