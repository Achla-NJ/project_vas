<div class="app-sidebar">
    <div class="logo">
        <a href="{{route('admin.dashboard')}}" class="logo-icon"><span class="logo-text">{{ env('APP_NAME') }}</span></a>
        {{-- <div class="sidebar-user-switcher user-activity-online">
            <a href="#">
                <img src="{{asset('assets/images/avatars/avatar.png')}}"> 
            </a>
        </div> --}}
    </div>
    <div class="app-menu">
        <ul class="accordion-menu">
            <li class="sidebar-title">
                Apps
            </li>
            {{-- <li class="active-page">
                <a href="index.html" class="active"><i class="material-icons-two-tone">dashboard</i>Dashboard</a>
            </li> --}}
            @can('dashboard')
                <li class="active-page">
                    <a href="{{route('admin.dashboard')}}" class="active"><i class="material-icons-two-tone">dashboard</i>Dashboard</a>
                </li>
            @endcan    
            @can('user_access')
            <li class="">
                <a href="{{route('admin.users.index')}}" >
                    <i class="material-icons-two-tone">sentiment_satisfied_alt</i>Users
                </a>               
            </li>
            @endcan        

            @can('role_access')
            <li class="">
                <a href="{{route('admin.roles.index')}}" >
                    <i class="material-icons-two-tone">edit</i>Roles
                </a>               
            </li>
            @endcan        

            @can('permission_access')
            <li class="">
                <a href="{{route('admin.permissions.index')}}" >
                    <i class="material-icons-two-tone">grid_on</i>Permissions
                </a>               
            </li>
            @endcan        
                 
            @can('company_access')
            <li class="">
                <a href="{{route('admin.companies.index')}}" >
                    <i class="material-icons-two-tone">analytics</i>Companies
                </a>               
            </li>
            @endcan 

            @can('history')
            <li class="">
                <a href="{{route('admin.history.index')}}" >
                    <i class="material-icons-two-tone">analytics</i>History
                </a>               
            </li>
            @endcan 
            
            <li class="">
                <a href="{{route('admin.signout')}}" >
                    <i class="material-icons-two-tone">done</i>Log out
                </a>               
            </li>            
        </ul>
    </div>
</div>
