<div class="row">
    <div class="col-lg-6">
        <div class="row">
            <div class="col-12">{{$task->name}}</div>
            <div class="col-12"><b>Project : </b>test</div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="row">
            <div class="col-12">
                <p><span class="badge" style="background: green">test</span></p>
                <p><b>Start Date : </b>{{date('M d, Y',strtotime($task->start_date))}}</p>
                <p><b>Deadline : </b>{{date('M d, Y',strtotime($task->end_date))}}</p>
                <p><b>Estimate Time : </b>{{$task->estimate_time}} {{$task->estimate_type}}</p>
                <button type="button" class="btn btn-success">Start Timer</button>
                <p><b>Total time logged: 00:00:00</b></p>
            </div>
        </div>
        
    </div>
    
    <div class="col-lg-12 my-3">
        <hr>
        <p class="text-center">Activity</p>
        @foreach ($activities as $activity)
        <div class="pl15 pr15 mt15 list-container project-activity-logs-container">
            <div class="d-flex border-bottom mb-3">
                <div class="flex-shrink-0 me-2 mt-3">
                    <span class="avatar avatar-xs">
                        <img src="http://team_project.local/assets/images/avatar.jpg" alt="..." style="height: 50px; border-radius:50%;" >
                    </span>
                </div>
                <div class="p-2 w-100">
                    <div class="card-title">
                        <a href="http://team_project.local/index.php/team_members/view/17" class="dark strong">Achla  Dhiman</a>
                        <small><span class="text-off">Today at 01:03:47 PM</span></small>
                    </div>

                    <p>
                        <span class="badge bg-success">Added</span>
                        <span class="text-break">Task: <a href="#" title="Task info #1872" class="dark" data-post-id="1872" data-modal-lg="1" data-act="ajax-modal" data-title="Task info #1872" data-action-url="http://team_project.local/index.php/projects/task_view"> #1872 - test</a></span>
                                        </p>
                        </div>
            </div>
        </div>
        @endforeach
    </div>
</div>