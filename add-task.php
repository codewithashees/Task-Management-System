<?php
session_start();
require "init.php";
if(!isset($_SESSION['login'])){
	header("location:index.php");
}

$cur_url =  $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];//Not in use

//getting project_id from get method for adding task into paticular project
if(isset($_GET['project_id'])){
	$project_id = $_GET['project_id'];
	try{
	$stmt = $con->prepare("SELECT project_name FROM projects WHERE project_id = :project_id");
	$stmt->execute(array(':project_id'=>$project_id));
	$row2 = $stmt->fetch(PDO::FETCH_ASSOC);
	$project_name = $row2['project_name'];
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	
}else{
	$project_name = "Self";
	$project_id = 0;
}

//function for Generate Autoincrement number
$stmt = $con->prepare("SELECT task_id FROM tasks order by task_id desc");
$stmt->execute();
$last_id = $stmt->fetch(PDO::FETCH_ASSOC)['task_id'];
function task_num($input, $pad_len = 7, $prefix = null) {
    if ($pad_len <= strlen($input))
        trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate Task number', E_USER_ERROR);
    if (is_string($prefix))
        return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));
    return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
}

$tnum = task_num($last_id+1, 7, 'DCMA-T');

//Insert| Add Task
if(isset($_POST['create_task'])){
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	//upload files
	if(isset($_FILES['task_file'])){
		$file_name = $_FILES['task_file']['name'];
		$file_tmp = $_FILES['task_file']['tmp_name'];
		$file_path = "upload_files/";
	}
	
	$user_id_and_name = test_input($_POST['assigned']);
	$arr_id_name = explode("/", $user_id_and_name);
	$user_id = $arr_id_name[0];
	
	$task_no = test_input($_POST['task_no']);
	$task_name = test_input($_POST['task_name']);
	$assigned = test_input($_POST['assigned']);
	$task_description = htmlentities(str_replace("'","&#x2019;",$_POST['task_description']));
	$task_priority = test_input($_POST['task_priority']);
	$task_status = test_input($_POST['task_status']);
	
	try{
		$sql = "INSERT INTO tasks (user_id, project_id, project_name, task_no, task_name, task_file, assigned, task_description, task_priority, task_status)VALUES(?,?,?,?,?,?,?,?,?,?)";
		$stmt = $con->prepare($sql);
		$stmt->execute(array($user_id,$project_id,$project_name,$task_no,$task_name,$file_path.$file_name,$assigned,$task_description,$task_priority,$task_status));
		
		echo ("<script LANGUAGE='JavaScript'>
		window.alert('Task Assigned Successfully');
		window.location.href;
		</script>");
		
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	$con = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DCMA | Add Task</title>

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
  <?php $url = "/add-task.php"; include('sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Task</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Task</li>
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
              <form method="POST" action="" enctype="multipart/form-data">
                <div class="card-body">
				<div class="row">
				  <div class="form-group col-md-6">
					<label for="taskNo">Task No.</label>
					<input type="text" id="taskNo" name="task_no" value="<?php echo $tnum ?>" class="form-control form-control-sm" readonly>
				  </div>
				  <div class="form-group col-md-6">
					<label for="taskName">Task Name</label>
					<input type="text" id="taskName" name="task_name" class="form-control form-control-sm" required>
				  </div>
				  <div class="form-group col-md-6">
                    <label for="selectUser">Assign To</label>
                    <select id="selectUser" name="assigned" class="form-control form-control-sm" required>
						<option selected disabled>Select one</option>
						<?php
						$result = $con->prepare("SELECT user_id,firstname FROM users WHERE role='user' order by firstname ASC");
						$result->execute();
						while($row = $result->fetch(PDO::FETCH_ASSOC)) { 
							echo "<option value='$row[user_id]/$row[firstname]'>$row[firstname]</option>"; 
						} 
						?> 
                    </select>
                  </div>
				  
				  <div class="form-group col-md-6">
					<label for="task_file">File input</label>
					<input type="file" id="task_file" name="task_file" class="form-control form-control-sm">
                  </div>
				  
				  <!--<div class="form-group col-md-6">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="task_file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>-->
				  
				  <div class="form-group col-md-12">
					<label for="summernote">Task Description</label>
					<textarea id="summernote" name="task_description" class="form-control form-control-sm" rows="3"></textarea>
				  </div>
				  <div class="form-group col-md-6">
                    <label for="taskPriority">Task Priority</label>
                    <select id="taskPriority" name="task_priority" class="form-control form-control-sm" required>
						<option selected disabled>Select One</option>
						<option value="Urgent">Urgent</option>
						<option value="High">High</option>
						<option value="Medium">Medium</option>
						<option value="Low">Low</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputStatus">Status</label>
                    <select id="inputStatus" name="task_status" class="form-control form-control-sm" required>
						<option selected disabled>Select one</option>
						<option value="Pending">Pending</option>
						<option value="Canceled">Canceled</option>
						<option value="Completed">Completed</option>
                    </select>
                  </div>
				</div>
                </div>
                <!-- /.card-body -->
				
                <div class="card-footer">
				  <div class="row">
					<div class="col-12">
						<a href="#" class="btn btn-secondary">Cancel</a>
						<button type="submit" name="create_task" class="btn btn-success float-right">Create Task</button>
					</div>
				  </div>
                </div>
              </form>
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
</script>

</body>
</html>
