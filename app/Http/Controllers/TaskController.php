<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Http\Requests\TaskRequest;
use App\Models\Activity;
use App\Models\TaskUser;
use App\Models\TaskStatus;
use Auth;
class TaskController extends Controller
{
    /**
     * Display all tasks
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $tasks = Task::latest()->get();

        return view('admin.tasks.index', compact('tasks'));
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        if(Auth::user()->can('add_task')){
            return view('admin.tasks.manage',['clients' => User::role('client')->get(),'users' => User::role('user')->get(),'disp'=>'1','statuses'=>TaskStatus::all(),'projects'=>Project::latest()->get()]);
        }
        return abort(401, 'Unauthorized');
    }

    /**
     * Store a newly created user
     * 
     * @param Task $task
     * @param TaskRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request) 
    {
        if(Auth::user()->can('add_task')){
            $data = $request->validated();
            Task::create($data);
            
            return redirect()->route('admin.tasks.index')
                ->withSuccess(__('Task created successfully.'));
        }
        return abort(401, 'Unauthorized');
    }
    /**
     * Edit user data
     * 
     * @param Task $task
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task) 
    {
        if(Auth::user()->can('edit_task')){
            return view('admin.tasks.manage', [
                'task' => $task,
                'clients' => User::role('client')->get(),'users' => User::role('user')->get(),
                'disp'=>'1','statuses'=>TaskStatus::all(),'projects'=>Project::latest()->get()
            ]);
        }
        return abort(401, 'Unauthorized');
        
    }

    /**
     * Update user data
     * 
     * @param Task $task
     * @param TaskRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Task $task, TaskRequest $request) 
    {
        if(Auth::user()->can('edit_task')){
            $task->update($request->validated());
            return redirect()->route('admin.tasks.index')
                ->withSuccess(__('Task updated successfully.'));
        }
        return abort(401, 'Unauthorized');
    }

    /**
     * Delete user data
     * 
     * @param Task $task
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task) 
    {
        if(Auth::user()->can('delete_task')){
            $task->delete();

            return redirect()->route('admin.tasks.index')
                ->withSuccess(__('Task deleted successfully.'));
        }
        return abort(401, 'Unauthorized');
    }

    public function show(Task $task)
    {
        return view('components.task', [
            'task' => $task,
            'clients' => User::role('client')->get(),'users' => User::role('user')->get(),
            'disp'=>'0','statuses'=>TaskStatus::all(),'projects'=>Project::latest()->get(),
            'activities'=>Activity::where('log_type','task')->where('log_id',$task->id)->latest()->get()
        ]);
    }
}