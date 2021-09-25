<?php
session_start();
require "init.php";
if(!isset($_SESSION['login'])){
	header("location:index.php");
}

//getting project_id from get method for adding task into paticular project
if(isset($_GET['project_id'])){
	$project_id = $_GET['project_id'];
}

//fetching task details for showing and edit
if(isset($_GET['tsk_id'])){
	$tsk_id = $_GET['tsk_id'];
	$result = $con->prepare("SELECT * FROM tasks WHERE task_id = :tsk_id");
	$result->execute(array(':tsk_id'=>$tsk_id));
	$row2 = $result->fetch(PDO::FETCH_ASSOC);
	
	$l_taskname = $row2['task_name'];
	$l_assignto = $row2['assigned'];
	$l_priority = $row2['task_priority'];
	$l_status = $row2['task_status'];
}

//Update| Update Task
if(isset($_POST['update_task'])){
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	$user_id_and_name = test_input($_POST['assigned']);
	$arr_id_name = explode("/", $user_id_and_name);
	$user_id = $arr_id_name[0];
	
	$project_id = test_input($_POST['project_id']);
	
	$task_no = test_input($_POST['task_no']);
	$task_name = test_input($_POST['task_name']);
	$assigned = test_input($_POST['assigned']);
	$task_description = test_input($_POST['task_description']);
	$task_priority = test_input($_POST['task_priority']);
	$task_status = test_input($_POST['task_status']);
	
	//task activity query
	$task_update_note = test_input($_POST['task_update_note']);
	$user_name = $_SESSION['firstname'];
	
	try{
		//update task query
		$update_query = "UPDATE tasks SET user_id = :user_id, project_id = :project_id, task_no = :task_no, task_name = :task_name,assigned=:assigned,task_description=:task_des,task_priority=:task_priority,task_status=:task_status WHERE task_id = :task_id";
		$stmt = $con->prepare($update_query);
		$stmt->execute(array(':user_id'=>$user_id,':project_id'=>$project_id,':task_no'=>$task_no,':task_name'=>$task_name,':assigned'=>$assigned,':task_des'=>$task_description,':task_priority'=>$task_priority,':task_status'=>$task_status,':task_id'=>$tsk_id));
		
		//task activity query History
		$insert_activity = "INSERT INTO task_activity (user_name, task_no, task_name, u_taskname, assign_to, u_assignto, task_priority, u_priority, task_status, u_status, task_update_note)VALUES(?,?,?,?,?,?,?,?,?,?,?)";
		$stmt2 = $con->prepare($insert_activity);
		$stmt2->execute(array($user_name,$task_no,$l_taskname,$task_name,$l_assignto,$assigned,$l_priority,$task_priority,$l_status,$task_status,$task_update_note));
		
		echo ("<script LANGUAGE='JavaScript'>
		window.alert('Task Updated Successfully');
		window.location.href='manage-task.php';
		</script>");
		
	}catch(PDOExeption $e){
		echo $e->getMessage();
	}
	
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DCMA | Update Task</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php include('header.php'); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include('sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Task</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Task</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
		<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Task Information</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="">
                <div class="card-body">
				<div class="row">
				  <input type="hidden" name="project_id" value="<?=$row2['project_id']?>" > <!--use for update task-->
				  <div class="form-group col-md-6">
					<label for="taskNo">Task No.</label>
					<input type="text" id="taskNo" name="task_no" value="<?php echo $row2['task_no'] ?>" class="form-control form-control-sm" readonly>
				  </div>
				  <div class="form-group col-md-6">
					<label for="taskName">Task Name</label>
					<input type="text" id="taskName" name="task_name" value="<?php echo $row2['task_name'] ?>" class="form-control form-control-sm" required>
				  </div>
				  <div class="form-group col-md-6">
                    <label for="selectUser">Assign To</label>
                    <select id="selectUser" name="assigned" class="form-control form-control-sm custom-select" required>
						<option value="<?=$row2['assigned']?>"><?=$row2['assigned']?></option>
						<?php 
						$result=$con->prepare("SELECT user_id,firstname FROM users WHERE role='user' order by firstname ASC");
						$result->execute();
						while($row=$result->fetch(PDO::FETCH_ASSOC)) { 
							echo "<option value='$row[user_id]/$row[firstname]'>$row[firstname]</option>"; 
						} 
						?> 
                    </select>
                  </div>
				  <div class="form-group col-md-12">
					<label for="inputDescription">Task Description</label>
					<textarea id="summernote" name="task_description" class="form-control form-control-sm" rows="3"><?php echo $row2['task_description'] ?></textarea>
				  </div>
				  <div class="form-group col-md-6">
                    <label for="taskPriority">Task Priority</label>
                    <select id="taskPriority" name="task_priority" class="form-control form-control-sm custom-select" required>
						<option value="<?=$row2['task_priority']?>"><?=$row2['task_priority']?></option>
						<option value="Urgent">Urgent</option>
						<option value="High">High</option>
						<option value="Medium">Medium</option>
						<option value="Low">Low</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputStatus">Status</label>
                    <select id="inputStatus" name="task_status" class="form-control form-control-sm custom-select" required>
						<option value="<?=$row2['task_status']?>"><?=$row2['task_status']?></option>
						<option value="Pending">Pending</option>
						<option value="Canceled">Canceled</option>
						<option value="Completed">Completed</option>
                    </select>
                  </div>
				  
				  <!--task update note-->
				  <div class="form-group col-md-12">
					<label for="task_update_note">Task Update Note</label>
					<textarea style="background-color:cornsilk;" id="task_update_note" name="task_update_note" class="form-control form-control-sm" rows="3"></textarea>
				  </div>
				  
				</div>
                </div>
                <!-- /.card-body -->
				
                <div class="card-footer">
				  <div class="row">
					<div class="col-12">
						<a href="#" class="btn btn-secondary">Cancel</a>
						<button type="submit" name="update_task" class="btn btn-success float-right">Update Task</button>
					</div>
				  </div>
                </div>
              </form>
            </div>
			<!--Files-->
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Task Files</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
						<i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body row">
					<div class="col-md-12">
                    <a href="<?=$row2['task_file']?>"><i class="fas fa-file"></i> <?=$row2['task_file']?></a>
					</div>
				</div>
			</div>
			
			<!--history activity-->
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Recent Activity</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
						<i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body">
					<div id="activity-data">
					<!--<h4>Recent Activity</h4>-->
                    
					</div>
				</div>
			</div>
			
          <!-- /.card -->
        </div>
      </div>
	  
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('footer.php'); ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!--toastr-->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>

<script>
function alrt(){
	toastr.success('hiiii');
}

// Summernote
  $('#summernote').summernote({
	 height:['100'],
	 lineHeights:['0.2'],
	 placeholder: 'write here...'
  });

//Activity
  $(document).ready(function(){
	  //load activity
	  function loadActivity(){
		  var task_no = $('#taskNo').val();
		  $.ajax({
			  url:"insert.php",
			  type:"POST",
			  data:{loadActivity:'Yes', task_no:task_no},
			  success: function(data){
				  $('#activity-data').html(data);
			  }
		  });
	  }
	  loadActivity();
  });
</script>

</body>
</html>
