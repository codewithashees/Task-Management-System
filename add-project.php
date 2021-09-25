<?php
session_start();
require "init.php";
if(!isset($_SESSION['login'])){
	header("location:index.php");
}

$stmt = $con->prepare("SELECT project_id FROM projects order by project_id desc");
$stmt->execute();
$last_id = $stmt->fetch(PDO::FETCH_ASSOC)['project_id'];

//function for Generate Autoincrement number
function project_num($input, $pad_len = 7, $prefix = null) {
    if ($pad_len <= strlen($input))
        trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate project number', E_USER_ERROR);
    if (is_string($prefix))
        return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));
    return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
}

$pnum = project_num($last_id+1, 7, 'DCMA-P');

//Submitting Project details
if(isset($_POST['create_project'])){
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	$project_number = test_input($_POST['project_number']);
	$project_name = test_input($_POST['project_name']);
	$client_company = test_input($_POST['client_company']);
	$start_date = test_input($_POST['start_date']);
	$end_date = test_input($_POST['end_date']);
	$status = test_input($_POST['status']);
	$description = htmlentities(str_replace("'","&#x2019;",$_POST['description']));
	
	try{
		$sql = "INSERT INTO projects (project_number, project_name, client_company, start_date, end_date, status, description)VALUES(?,?,?,?,?,?,?)";
		$stmt = $con->prepare($sql);
		$stmt->execute(array($project_number,$project_name,$client_company,$start_date,$end_date,$status,$description));
		
		echo ("<script LANGUAGE='JavaScript'>
		alert('Project Added Successfully');
		window.location.href='add-project.php';
		</script>");
		
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	$con = null;
}

//fetching submitted project details
if(isset($_GET['project_id'])){
	$project_id = $_GET['project_id'];
	$result = $con->prepare("SELECT * FROM projects WHERE project_id = :project_id");
	$result->execute(array(':project_id'=>$project_id));
	$row = $result->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DCMA | Add Project</title>

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
  <?php $url = "/add-project.php"; include('sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
				<?php if(!isset($_GET['project_id'])){
					echo "Add Project";
				}else{
					echo "Update Project";
				}
				?>
			</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">Home</li>
			  <li class="breadcrumb-item"><a href="manage-project.php">Manage Project</a></li>
              <li class="breadcrumb-item active"><a href="add-project.php">Add Project</a></li>
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
                <h3 class="card-title">Project Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="">
                <div class="card-body">
				<div class="row">
				  <div class="form-group col-md-6">
					<label for="project_number">Project No.</label>
					<input type="text" id="project_number" name="project_number" value="<?php echo isset($row['project_number']) ? $row['project_number'] : $pnum ?>" class="form-control form-control-sm" readonly>
				  </div>
				  
				  <div class="form-group col-md-6">
					<label for="start_date">Start Date:</label>
					<input type="date" id="start_date" name="start_date" value="<?php echo isset($row['start_date']) ? $row['start_date'] : '' ?>" class="form-control form-control-sm" required>
				  </div>
				  <div class="form-group col-md-6">
					<label for="project_name">Project Name</label>
					<input type="text" id="project_name" name="project_name" value="<?php echo isset($row['project_name']) ? $row['project_name'] : '' ?>" class="form-control form-control-sm" required>
				  </div>
				  <div class="form-group col-md-6">
					<label for="end_date">End Date:</label>
					<input type="date" id="end_date" name="end_date" value="<?php echo isset($row['end_date']) ? $row['end_date'] : '' ?>" class="form-control form-control-sm" required>
                  </div>
				  <div class="form-group col-md-6">
					<label for="client_company">Client Company</label>
					<input type="text" id="client_company" name="client_company" value="<?php echo isset($row['client_company']) ? $row['client_company'] : '' ?>" class="form-control form-control-sm" required>
                  </div>
				  <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control form-control-sm" required>
						<?php if(isset($row['status'])){echo '<option value="'.$row['status'].'">'.$row['status'].'</option>';}else{echo '<option selected disabled>Select One</option>';}?>
						<option value="Open">Open</option>
						<option value="In Progress">In Progress</option>
						<option value="Pending">Pending</option>
						<option value="Completed">Completed</option>
						<option value="Canceled">Canceled</option>
                    </select>
                  </div>
				  <div class="form-group col-md-12">
					<label for="description">Project Description</label>
					<textarea id="description" name="description" class="form-control form-control-sm summernote" rows="2">
						<?php echo isset($row['description']) ? $row['description'] : '' ?>
					</textarea>
				  </div>
				</div>
                </div>
                <!-- /.card-body -->
				
                <div class="card-footer">
				  <div class="row">
					<div class="col-12">
						<a href="#" class="btn btn-sm btn-secondary">Cancel</a>
						
						<?php if(!isset($_GET['project_id'])){?>
						<button type="submit" name="create_project" class="btn btn-sm btn-success float-right">Add New Project</button>
						<?php } ?>
						
						<?php if(isset($_GET['project_id'])){?>
						<a href="javascript:void(0)" onclick="update_project(<?=$row['project_id']?>)" class="btn btn-sm btn-success float-right">Update</a>
						<?php } ?>
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
$(function () {
  // Summernote
  $('.summernote').summernote({
	 height:['100'],
	 lineHeights:['0.2'],
	 placeholder: 'write here...'
  });
});

//updateProject JS
  function update_project(projectid){
	  
	  var project_number = $('#project_number').val();
	  var project_name = $('#project_name').val();
	  var client_company = $('#client_company').val();
	  var start_date = $('#start_date').val();
	  var end_date = $('#end_date').val();
	  var status = $('#status').val();
	  var description = $('#description').val();
	  
	  
	  var method = "update_project_details";
	  
	  var data = "method="+method+ "&projectid="+projectid+ "&project_number="+project_number+ "&project_name="+project_name+ "&start_date="+start_date+ "&client_company="+client_company+ "&description="+description+ "&end_date="+end_date+ "&status="+status;
	  
	  $.ajax({
		  cache:false,
		  url:"ajax.php",
		  type:"POST",
		  data: data,
		  success: function(response){
			  toastr.success(response);
		  }
	  });
	  
  }
</script>
</body>
</html>
