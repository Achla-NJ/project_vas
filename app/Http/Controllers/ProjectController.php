<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ProjectRequest;
use App\Models\ProjectUser;
use App\Models\Activity;
use Auth;
class ProjectController extends Controller
{
    /**
     * Display all projects
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $projects = Project::latest()->get();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        if(Auth::user()->can('add_project')){
            return view('admin.projects.manage',['clients' => User::role('client')->get(),'users' => User::role('user')->get(),'disp'=>'1']);
        }
        return abort(401, 'Unauthorized');
    }

    /**
     * Store a newly created user
     * 
     * @param Project $project
     * @param ProjectRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request) 
    {
        if(Auth::user()->can('add_project')){
            $data = $request->validated();
            $data['users'] ="";
            $project = Project::create($data);

            Activity::create([
                'name'=>$project->name,
                'user_id'=>Auth::user()->id,
                'log_type'=>'project',
                'activity'=>'added',
                'log_id'=>$project->id,
            ]);
            foreach ($request->users as $user) {
                ProjectUser::create(['user_id'=>$user,'project_id'=>$project->id]);
            }
            
            return redirect()->route('admin.projects.index')
                ->withSuccess(__('Project created successfully.'));
        }
        return abort(401, 'Unauthorized');
    }
    /**
     * Edit user data
     * 
     * @param Project $project
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project) 
    {
        if(Auth::user()->can('edit_project')){
            return view('admin.projects.manage', [
                'project' => $project,
                'clients' => User::role('client')->get(),'users' => User::role('user')->get(),
                'project_users' => ProjectUser::where('project_id',$project->id)->get(),'disp'=>'1'
            ]);
        }
        return abort(401, 'Unauthorized');
        
    }

    /**
     * Update user data
     * 
     * @param Project $project
     * @param ProjectRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project, ProjectRequest $request) 
    {
        if(Auth::user()->can('edit_project')){
            ProjectUser::where('project_id',$project->id)->delete();
            $project->update($request->validated());
            
            Activity::create([
                'name'=>$project->name,
                'user_id'=>Auth::user()->id,
                'log_type'=>'project',
                'activity'=>'updated',
                'log_id'=>$project->id,
                'updation'=>json_encode($project->getChanges())
            ]);

            foreach ($request->users as $user) {
                ProjectUser::create(['user_id'=>$user,'project_id'=>$project->id]);
            }
            return redirect()->route('admin.projects.index')
                ->withSuccess(__('Project updated successfully.'));
        }
        return abort(401, 'Unauthorized');
    }

    /**
     * Delete user data
     * 
     * @param Project $project
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project) 
    {
        if(Auth::user()->can('delete_project')){
            $project->delete();

            return redirect()->route('admin.projects.index')
                ->withSuccess(__('Project deleted successfully.'));
        }
        return abort(401, 'Unauthorized');
    }

    public function show(Project $project)
    {
        return view('admin.projects.manage', [
            'project' => $project,
            'clients' => User::role('client')->get(),'users' => User::role('user')->get(),
            'project_users' => ProjectUser::where('project_id',$project->id)->get(),'disp'=>'0'
        ]);
    }

    public function getProjectUser(Request $request){
        $html = "<option value='0'>-Select-</option>";
        $project_users = ProjectUser::where('project_id',$request->project_id)->get();
        foreach($project_users as $project_user){
            $user = User::find($project_user->user_id);
            $html .= "<option value='$user->id'>$user->name</option>";
        }
        return  \Response::json(['status'=>true,'data'=>$html]);
    }
}