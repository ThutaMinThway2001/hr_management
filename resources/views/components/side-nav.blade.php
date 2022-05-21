<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="#">pro sidebar</a>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
      <div class="sidebar-header">
        <div class="user-pic">
          <img class="img-responsive img-rounded" src="{{auth()->user()->profile_img_path()}}"
            alt="">
        </div>
        <div class="user-info">
          <span class="user-name">
            <strong>{{auth()->user()->name}}</strong>
          </span>
          <span class="user-role">{{auth()->user()->department? auth()->user()->department->title : "No Departments Yet!"}}</span>
          <span class="user-status">
            <i class="fa fa-circle"></i>
            <span>Online</span>
          </span>
        </div>
      </div>
      <!-- sidebar-header  -->

      <div class="sidebar-menu">
        <ul>
          <li class="header-menu">
            <span>General</span>
          </li>
          <li>
              <a href="#">
                <i class="fa fa-home"></i>
                <span>Home</span>
              </a>
          </li>

          @can('view_employee')
          <li>
            <a href="{{route('employee.index')}}">
              <i class="fa fa-users"></i>
              <span>Employees</span>
            </a>
          </li>
          @endcan

          @can('view_department')
          <li>
            <a href="{{route('departments.index')}}">
              <i class="fas fa-boxes"></i>
              <span>Departments</span>
            </a>
          </li>
          @endcan

          @can('view_role')
          <li>
            <a href="{{route('roles.index')}}">
              <i class="fas fa-chalkboard-teacher"></i>
              <span>Roles</span>
            </a>
          </li>            
          @endcan

          @can('view_permission')
          <li>
            <a href="{{route('permissions.index')}}">
              <i class="fas fa-shield-alt"></i>
              <span>Permissions</span>
            </a>
          </li>
          @endcan

          @can('view_attendance')
          <li>
            <a href="{{route('attendances.index')}}">
              <i class="fas fa-calendar-alt"></i>
              <span>Attendances</span>
            </a>
          </li>
          @endcan

          @can('view_attendance_overview');
          <li>
            <a href="{{route('attendance.overview')}}">
              <i class="fas fa-calendar-alt"></i>
              <span>Overview</span>
            </a>
          </li>
          @endcan

          @can('view_company_setting')
          <li>
            <a href="{{route('company-settings.show', 1)}}">
              <i class="fas fa-building"></i>
              <span>Company Settings</span>
            </a>
          </li>
          @endcan

          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-globe"></i>
              <span>Maps</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Google maps</a>
                </li>
                <li>
                  <a href="#">Open street map</a>
                </li>
              </ul>
            </div>
          </li>

        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
  </nav>