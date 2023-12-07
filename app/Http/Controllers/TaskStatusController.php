<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskStatus;
use Auth;
use App\Http\Requests\TaskStatusRequest;
class TaskStatusController extends Controller
{
    /**
     * Display all task_statuses
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $task_statuses = TaskStatus::latest()->get();

        return view('admin.task_statuses.index', compact('task_statuses'));
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        if(Auth::user()->can('add_task_status')){
            return view('admin.task_statuses.manage',['disp'=>'1']);
        }
        return abort(401, 'Unauthorized');
    }

    /**
     * Store a newly created user
     * 
     * @param TaskStatus $task_status
     * @param TaskStatusRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(TaskStatusRequest $request) 
    {
        if(Auth::user()->can('add_task_status')){
            $data = $request->validated();
            TaskStatus::create($data);
            
            return redirect()->route('admin.task-statuses.index')
                ->withSuccess(__('TaskStatus created successfully.'));
        }
        return abort(401, 'Unauthorized');
    }
    /**
     * Edit user data
     * 
     * @param TaskStatus $task_status
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskStatus $task_status) 
    {
        if(Auth::user()->can('edit_task_status')){
            return view('admin.task_statuses.manage', [
                'task_status' => $task_status,'disp'=>'1'
            ]);
        }
        return abort(401, 'Unauthorized');
        
    }

    /**
     * Update user data
     * 
     * @param TaskStatus $task_status
     * @param TaskStatusRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(TaskStatus $task_status, TaskStatusRequest $request) 
    {
        if(Auth::user()->can('edit_task_status')){
            $task_status->update($request->validated());
            return redirect()->route('admin.task-statuses.index')
                ->withSuccess(__('TaskStatus updated successfully.'));
        }
        return abort(401, 'Unauthorized');
    }

    /**
     * Delete user data
     * 
     * @param TaskStatus $task_status
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskStatus $task_status) 
    {
        if(Auth::user()->can('delete_task_status')){
            $task_status->delete();

            return redirect()->route('admin.task-statuses.index')
                ->withSuccess(__('TaskStatus deleted successfully.'));
        }
        return abort(401, 'Unauthorized');
    }

    public function show(TaskStatus $task_status)
    {
        return view('admin.task_statuses.manage', [
            'task_status' => $task_status,'disp'=>'0'
        ]);
    }
}