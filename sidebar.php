<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="dist/img/dcma_logo.png" alt="DCMA Logo" class="brand-image img-circle elevation-3">
      <span class="brand-text font-weight-light"><h5>DCMA Technologies</h5></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/avatar.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['firstname']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
		  <?php if($_SESSION['role']=='admin'){?>
		  <li class="nav-item menu-open">
            <a href="admin-dashboard.php" class="nav-link <?php if($url == '/admin-dashboard.php'){echo 'active';} ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="manage-user.php" class="nav-link <?php if($url == '/add-user.php' or $url == '/manage-user.php'){echo 'active';} ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>Users</p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="#" class="nav-link <?php if($url == '/add-project.php' or $url == '/manage-project.php' or $url == '/view-project.php'){echo 'active';} ?>">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Projects</p>
			  <i class="right fas fa-angle-left"></i>
            </a>
			<ul class="nav nav-treeview">
			  <li class="nav-item">
                <a href="manage-project.php" class="nav-link <?php if($url == '/manage-project.php'){echo 'active';} ?>">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Manage Project</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="add-project.php" class="nav-link <?php if($url == '/add-project.php'){echo 'active';} ?>">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add Project</p>
                </a>
              </li>
            </ul>
          </li>
		  <li class="nav-item">
            <a href="#" class="nav-link <?php if($url == '/manage-task.php' or $url == '/add-task.php'){echo 'active';} ?>">
              <i class="nav-icon fas fa-tasks"></i>
              <p>Tasks</p>
			  <i class="right fas fa-angle-left"></i>
            </a>
			<ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="manage-task.php" class="nav-link <?php if($url == '/manage-task.php'){echo 'active';} ?>">
                  <i class="far fas fa-angle-right nav-icon"></i>
                  <p>Manage Task</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="add-task.php" class="nav-link <?php if($url == '/add-task.php'){echo 'active';} ?>">
                  <i class="far fas fa-angle-right nav-icon"></i>
                  <p>Add Task</p>
                </a>
              </li>
            </ul>
          </li>
		  <?php } ?>
		  
		  <?php if($_SESSION['role']=='user'){?>
		  <li class="nav-item menu-open">
            <a href="user-dashboard.php" class="nav-link <?php if($url == '/user-dashboard.php'){echo 'active';} ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
		  <?php } ?>
		  <li class="nav-item">
            <a href="assigned-task.php" class="nav-link <?php if($url == '/assigned-task.php'){echo 'active';} ?>">
              <i class="nav-icon fas fa-tasks"></i>
              <p>Assigned Task</p>
            </a>
		  </li>
		  <li class="nav-item">
            <a href="todo-list.php" class="nav-link <?php if($url == '/todo-list.php'){echo 'active';} ?>">
              <i class="nav-icon fas fa-clipboard"></i>
              <p>My To Do List</p>
            </a>
		  </li>
		  
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>