<ul class="navbar-nav sidebar sidebar-light accordion " id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center bg-gradient-primary  justify-content-center" href="index.php">

      <div class="sidebar-brand-text mx-3">Super Admin <span><i class="fa fa-star text-warning" aria-hidden="true"></i></span></div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
      <a class="nav-link" href="index.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Class and Batchs
    </div>
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
        <i class="fas fa-chalkboard"></i>
          <span>Manage Classes</span>
      </a>
      <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Classes</h6>
            <a class="collapse-item" href="createClass.php">Create Class</a>
        </div>
      </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapusers" aria-expanded="true" aria-controls="collapseBootstrapusers">
          <i class="fas fa-code-branch"></i>
          <span>Manage Batch</span>
        </a>
        <div id="collapseBootstrapusers" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Batchs</h6>
            <a class="collapse-item" href="createClassArms.php">Create Batchs</a>
          </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Teachers
    </div>
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapassests" aria-expanded="true" aria-controls="collapseBootstrapassests">
        <i class="fas fa-chalkboard-teacher"></i>
        <span>Manage Teachers</span>
      </a>
      <div id="collapseBootstrapassests" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Manage Class Teachers</h6>
            <a class="collapse-item" href="createClassTeacher.php">Create Class Teachers</a>
        </div>
      </div>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
      Students
    </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap2" aria-expanded="true" aria-controls="collapseBootstrap2">
          <i class="fas fa-user-graduate"></i>
          <span>Manage Students</span>
        </a>
        <div id="collapseBootstrap2" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Students</h6>
            <a class="collapse-item" href="createStudents.php">Create Students</a>

          </div>
        </div>
    </li>
    <hr class="sidebar-divider">
      <div class="sidebar-heading">
      Attendance
      </div>
      </li>
        <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapcon"
          aria-expanded="true" aria-controls="collapseBootstrapcon">
          <i class="fa fa-calendar-alt"></i>
          <span>Manage Attendance</span>
        </a>
        <div id="collapseBootstrapcon" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Attendance</h6>
            <a class="collapse-item" href="viewAttendance.php">View Class Attendance</a>
            <!-- <a class="collapse-item" href="downloadRecord.php">Today's Report (xls)</a>
            <a class="collapse-item" href="downloadRecordWeekly.php">This week Report (xls)</a>
            <a class="collapse-item" href="downloadRecordMontly.php">This month Report (xls)</a> -->
          </div>
        </div>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
      Report
      </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapcon14"
          aria-expanded="true" aria-controls="collapseBootstrapcon14">
          <i class="fas fa-registered"></i>
          <span>Manage Reports</span>
        </a>
        <div id="collapseBootstrapcon14" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">List Reports</h6>
            <a class="collapse-item" href="ManageReportAdmin.php">View Reports</a>
            
          </div>
        </div>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
      Admin
      </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapcon1"
          aria-expanded="true" aria-controls="collapseBootstrapcon1">
          <i class="fas fa-user-plus"></i>
          <span>Manage Sub-Admin</span>
        </a>
        <div id="collapseBootstrapcon1" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Admin status</h6>
            <a class="collapse-item" href="ManageAdmin.php">Assgin admin</a>
            
          </div>
        </div>
      </li>
      <!-- <hr class="sidebar-divider">
      <div class="sidebar-heading">
      Organization details
      </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapcon5"
          aria-expanded="true" aria-controls="collapseBootstrapcon5">
          <i class="fas fa-sitemap"></i>
          <span>Organization Info</span>
        </a>
        <div id="collapseBootstrapcon5" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Identification</h6>
            <a class="collapse-item" href="organizationInfo.php">Org Info</a>
          </div>
        </div>

      </li> -->


</ul>