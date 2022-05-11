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

          <li>
              <a href="{{route('employee.index')}}">
                <i class="fa fa-users"></i>
                <span>Employees</span>
              </a>
          </li>

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