<?php
session_start();
require "init.php";
if(!isset($_SESSION['login'])){
	header("location:index.php");
}

if(isset($_POST['create_user'])){
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	$firstname = test_input($_POST['firstname']);
	$lastname = test_input($_POST['lastname']);
	$email = test_input($_POST['email']);
	$password = test_input($_POST['password']);
	$role = test_input($_POST['role']);
	$status = test_input($_POST['status']);
	
	try{
		$sql = "INSERT INTO users (firstname, lastname, email, password, role, status)VALUES(:firstname,:lastname,:email,:password,:role,:status)";
		$stmt = $con->prepare($sql);
		$stmt->execute(array(
		':firstname'=>$firstname,':lastname'=>$lastname,':email'=>$email,':password'=>$password,':role'=>$role,':status'=>$status,
		));
		echo ("<script LANGUAGE='JavaScript'>
		window.alert('User Created Successfully');
		window.location.href='manage-user.php';
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
  <title>DCMA | Add User</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php include('header.php'); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php $url = '/add-user.php'; include('sidebar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">Home</li>
			  <li class="breadcrumb-item"><a href="manage-user.php">Manage User</a></li>
              <li class="breadcrumb-item active"><a href="add-user.php">Add User</a></li>
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
                <h3 class="card-title">User Information</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="">
                <div class="card-body">
				  <div class="row">
				  <div class="form-group col-md-6">
					<label for="inputName">First Name</label>
					<input type="text" id="inputName" name="firstname" class="form-control form-control-sm" required>
				  </div>
				  
				  <div class="form-group col-md-6">
					<label for="inputName">Last Name</label>
					<input type="text" id="inputName" name="lastname" class="form-control form-control-sm">
				  </div>
				  
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control form-control-sm" id="exampleInputEmail1" name="email" placeholder="Enter email" required>
                  </div>
				  
				  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control form-control-sm" id="exampleInputPassword1" name="password" placeholder="Password" required>
                  </div>
				  
				  <div class="form-group col-md-6">
                    <label for="inputStatus">Role</label>
                    <select id="inputStatus" name="role" class="form-control form-control-sm" required>
						<option selected disabled>Select one</option>
						<option value="user">User</option>
						<option value="admin">Admin</option>
                    </select>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="inputStatus">Status</label>
                    <select id="inputStatus" name="status" class="form-control form-control-sm" required>
						<option selected disabled>Select one</option>
						<option value="1">Active</option>
						<option value="0">Inactive</option>
                    </select>
                  </div>
				  </div>
                </div>
                <!-- /.card-body -->
				
                <div class="card-footer">
				  <div class="row">
					<div class="col-12">
						<a href="#" class="btn btn-sm btn-secondary">Cancel</a>
						<button type="submit" name="create_user" class="btn btn-sm btn-success float-right">Add New User</button>
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
</body>
</html>
