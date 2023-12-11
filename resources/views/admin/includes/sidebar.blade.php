<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="sidebar-brand-text align-middle">
                AdminKit
            </span>
          
            
        </a>

        <div class="sidebar-user">
            <div class="d-flex justify-content-center">
                <div class="flex-shrink-0">
                    <img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1" alt="Charles Hall" />
                </div>
                <div class="flex-grow-1 ps-2">
                    <a class="sidebar-user-title" href="#">
                        Charles Hall
                    </a>
                    
                </div>
            </div>
        </div>

        <ul class="sidebar-nav">
            
            <li class="sidebar-item active">
                @can('dashboard')
                <a href="{{route('admin.dashboard')}}" class="sidebar-link">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>       
                @endcan        
            </li>
            @can('user_access')
            <li class="sidebar-item active">
                <a href="{{route('admin.users.index')}}" class="sidebar-link">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Users</span>
                </a>               
            </li>
            @endcan        

            @can('role_access')
            <li class="sidebar-item active">
                <a href="{{route('admin.roles.index')}}" class="sidebar-link">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Roles</span>
                </a>               
            </li>
            @endcan        

            @can('permission_access')
            <li class="sidebar-item active">
                <a href="{{route('admin.permissions.index')}}" class="sidebar-link">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Permission</span>
                </a>               
            </li>
            @endcan        
                 
            @can('company_access')
            <li class="sidebar-item active">
                <a href="{{route('admin.companies.index')}}" class="sidebar-link">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Companies</span>
                </a>               
            </li>
            @endcan        

            
            {{-- <li class="sidebar-item">
                <a data-bs-target="#pages" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="layout"></i> <span class="align-middle">Team</span>
                </a>
                <ul id="pages" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="{{route('admin.user-role','user')}}">Team Members</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{route('admin.departments.index')}}">Department</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{route('admin.task-statuses.index')}}">Status</a></li>
                </ul>
            </li> --}}
           
        </ul>
        
    </div>
</nav>