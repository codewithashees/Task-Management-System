<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require "init.php";
if(!isset($_SESSION['login'])){
	header("location:index.php");
}
if($_SESSION['role'] != 'admin'){
	header("location:index.php");
}
?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DCMA | Manage Task</title>

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
<div class="wrapper">
  <!-- Navbar -->
  <?php include('header.php');?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php $url = "/manage-task.php"; include('sidebar.php');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Task</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Manage Task</li>
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
				<a href="add-task.php" class="btn btn-sm btn-success float-right">Add Task</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-sm table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Task No.</th>
                    <th>Task Name</th>
					<th>Project</th>
                    <th>Assigned</th>
                    
					<th>Priority</th>
					<th>Status</th>
					<th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php 
				  $i=1;
				  $stmt=$con->prepare("SELECT * FROM tasks order by task_id DESC");
				  $stmt->execute();
				  while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {?> 
				  <?php
				  //For Task Status
				  if($row['task_status'] == 'Completed'){
					  $status_badge = "success";
				  }else if($row['task_status'] == 'Pending'){
					  $status_badge = "warning";
				  }else if($row['task_status'] == 'Canceled'){
					  $status_badge = "danger";
				  }
				  //For Task Priority
				  if($row['task_priority'] == 'Urgent'){
					  $priority_badge = "primary";
				  }else if($row['task_priority'] == 'High'){
					  $priority_badge = "danger";
				  }else if($row['task_priority'] == 'Medium'){
					  $priority_badge = "warning";
				  }else if($row['task_priority'] == 'Low'){
					  $priority_badge = "info";
				  }
				  ?>
				  
                  <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?=$row['task_no'];?></td>
                    <td><?=$row['task_name']?></td>
					<td><?=$row['project_name']?></td>
					<td><?=$row['assigned']?></td>
					
					<td class="project-state">
                        <span class="badge badge-<?=$priority_badge?>"><?=$row['task_priority']?></span>
                    </td>
					<td class="project-state">
                        <span class="badge badge-<?=$status_badge?>"><?=$row['task_status']?></span>
                    </td>
                    <td class="text-center">
					  <div class="btn-group">
                        <a href="update-task.php?tsk_id=<?=$row['task_id']?>" class="btn btn-default btn-flat">
                          <i class="far fa-edit"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="delete_task(<?=$row['task_id']?>)" class="btn btn-default btn-flat">
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
  //dataTable JS
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
  
  //Delete task
  function delete_task(task_id){
	  var result = confirm("Want to delete?");
	  if (result) {
		var method = "delete_task";
		var data = "method="+method + "&task_id="+task_id;
	  
		$.ajax({
		  cache:false,
		  url:"ajax.php",
		  type:"POST",
		  data: data,
		  success: function(response){
			  //alert(response);
			  toastr.success(response);
		  }
		});
	  }
	  
  }
</script>
</body>
</html>
