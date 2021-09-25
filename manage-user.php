<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require "init.php";
if(!isset($_SESSION['login'])){
	header("location:index.php");
}
?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DCMA | Manage User</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
</head>
<body class="hold-transition sidebar-mini">

  <!--Modal-->
      <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Default Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="">
				<!--inportant field-->
				<input type="hidden" id="userid" class="form-control">
				<!--/inportant field-->
				<div class="row">
				  <div class="form-group col-md-6">
					<label for="firstname">First Name</label>
					<input type="text" id="firstname" name="firstname" class="form-control form-control-sm" required>
				  </div>
				  
				  <div class="form-group col-md-6">
					<label for="lastname">Last Name</label>
					<input type="text" id="lastname" name="lastname" class="form-control form-control-sm">
				  </div>
				  
                  <div class="form-group col-md-6">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Enter email" required>
                  </div>
				  
				  <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input type="text" class="form-control form-control-sm" id="password" name="password" placeholder="Password" required>
                  </div>
				  
				  <div class="form-group col-md-6">
                    <label for="role">Role</label>
                    <select id="role" name="role" class="form-control form-control-sm custom-select" required>
						<option selected disabled>Select one</option>
						<option value="user">User</option>
						<option value="admin">Admin</option>
                    </select>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control form-control-sm custom-select" required>
						<option selected disabled>Select one</option>
						<option value="1">Active</option>
						<option value="0">Inactive</option>
                    </select>
                  </div>
				</div>
			  </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" onclick="update_user()" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
  <!--/Modal-->

<div class="wrapper">
  <!-- Navbar -->
  <?php include('header.php');?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php $url = '/manage-user.php'; include('sidebar.php');?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">Home</li>
              <li class="breadcrumb-item active"><a href="manage-user.php">Manage User</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable with minimal features & hover style</h3>
				<a href="add-user.php" class="btn btn-sm btn-success float-right">Add User</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-sm table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Email</th>
					<th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php 
				  $i=1;
				  $stmt = $con->prepare("SELECT * FROM users WHERE role='user' order by firstname ASC");
				  $stmt->execute();
				  while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {?> 
				  
				  <?php
				  if($row['status'] == 1){
					  $u_status = "success";
				  }else{
					  $u_status = "danger";
				  }
				  ?>
				  	
                  <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?=$row['firstname']." ".$row['lastname'];?></td>
                    <td><?=$row['email']?></td>
					<td><?=$row['role']?></td>
                    <td>
						<span class="badge badge-<?=$u_status?>"><?php if ($row['status'] == 1) { echo "Active";} else { echo "Inactive";} ?></span>
					</td>
                    <td class="text-center">
					  <div class="btn-group">
                        <button value="<?=$row['user_id'];?>" type="button" id="" class="btn btn-default btn-flat edit_user" data-toggle="modal" data-target="#modal-default">
                          <i class="far fa-edit"></i>
                        </button>
                        <a href="#" type="button" onclick="delete_user(<?=$row['user_id'];?>)" class="btn btn-default btn-flat">
                          <i class="far fa-trash-alt"></i>
                        </a>
                      </div>
					</td>
                  </tr>
				  
				  <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include('footer.php');?>

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
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!--toastr-->
<script src="plugins/toastr/toastr.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  //DataTable
  $(function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
  
  //showing user info
  $('.edit_user').on('click', function(){
	  var user_id = $(this).val();
	  $('#userid').val(user_id);
	  
	  var method = "fetch_user_data";
	  var data = "method="+method + "&user_id="+user_id;
	  
	  $.ajax({
		  cache:false,
		  url:"ajax.php",
		  type:"POST",
		  data: data,
		  success: function(response){
			  var json_data = JSON.parse(response);
			  $('#firstname').val(json_data.firstname);
			  $('#lastname').val(json_data.lastname);
			  $('#email').val(json_data.email);
			  $('#password').val(json_data.password);
			  $('#role').val(json_data.role);
			  $('#status').val(json_data.status);
			  //console.log(response);
		  }
		  
	  });
  });
  
  //update user info
  function update_user(){
	  var user_id = $('#userid').val();
	  var firstname = $('#firstname').val();
	  var lastname = $('#lastname').val();
	  var email = $('#email').val();
	  var password = $('#password').val();
	  var role = $('#role').val();
	  var status = $('#status').val();
	  
	  var method = "update_user_info";
	  var data = "method="+method + "&user_id="+user_id + "&firstname="+firstname + "&lastname="+lastname + "&email="+email + "&password="+password + "&role="+role + "&status="+status;
	  
	  $.ajax({
		  cache:false,
		  url:"ajax.php",
		  type:"POST",
		  data: data,
		  success: function(response){
			  //alert(response);
			  //toastr.error(response);
			  toastr.success(response);
		  }
		  
	  });
  }
  
  //Delete user
  function delete_user($user_id){
	  var result = confirm("Want to delete?");
	  if (result) {
		var user_id = $user_id;
		var method = "delete_user";
		var data = "method="+method + "&user_id="+user_id;
	  
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
	  
  }
</script>
</body>
</html>
