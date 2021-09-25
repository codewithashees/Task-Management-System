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
  <title>DCMA | Manage Project</title>

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
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include('header.php');?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php $url = "/manage-project.php"; include('sidebar.php');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Project</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">Home</li>
              <li class="breadcrumb-item active"><a href="manage-project.php">Manage Project</a></li>
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
                <h3 class="card-title">All Project</h3>
				<a href="add-project.php" class="btn btn-sm btn-success float-right">Add Project</a>
              </div>
              <!-- /.card-header -->
              <div style="display:none;" class="card-body">
                <table id="example2" class="table table-sm table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Project</th>
					<th>Client</th>
                    <th>Start Date</th>
                    <th>End Date</th>
					<th>Status</th>
					<th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php 
				  $i=1;
				  $stmt=$con->prepare("SELECT * FROM projects order by project_id DESC");
				  $stmt->execute();
				  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {?> 
				  	
                  <tr>
                    <td><?php echo $i++; ?></td>
                    <td>
						<a><?php echo ucwords($row['project_name']) ?></a>
                        <br>
                        <small>
                            Due: <?php echo date("Y-m-d",strtotime($row['end_date'])) ?>
                        </small>
					</td>
					<td><?=$row['client_company']?></td>
					<td><?=$row['start_date']?></td>
					<td><?=$row['end_date']?></td>
					<td class="project-state">
						<?php if($row['status'] == 'Pending'){
							echo "<span class='badge badge-warning'>".$row['status']."</span>";
						}else if($row['status'] == 'Completed'){
							echo "<span class='badge badge-success'>".$row['status']."</span>";
						}else if($row['status'] == 'In Progress'){
							echo "<span class='badge badge-info'>".$row['status']."</span>";
						}else if($row['status'] == 'Canceled'){
							echo "<span class='badge badge-danger'>".$row['status']."</span>";
						}else if($row['status'] == 'Open'){
							echo "<span class='badge badge-primary'>".$row['status']."</span>";
						}
                        ?>
                    </td>
                    <td class="text-center">
					  <div class="btn-group">
						<a href="add-project.php?project_id=<?=$row['project_id']?>"  class="btn btn-default btn-flat">
                          <i class="far fa-edit"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="delete_project(<?=$row['project_id']?>)" class="btn btn-default btn-flat">
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
		
		
		<div class="row">
		  <?php
			$stmt=$con->prepare("SELECT * FROM projects order by project_id DESC");
			$stmt->execute();
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {?>
			
          <div class="col-md-4">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <a href="view-project.php?id=<?=$row['project_id']?>"><h3 class="card-title"><?php echo ucwords($row['project_name']) ?></h3></a>

                <div class="card-tools">
                  <a href="add-project.php?project_id=<?=$row['project_id']?>" class="btn btn-tool">
                    <i class="far fa-edit"></i>
                  </a>
				  <button onclick="delete_project(<?=$row['project_id']?>)" type="button" class="btn btn-tool">
                    <i class="far fa-trash-alt"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
				<div class="direct-chat-msg">
					<span class="badge bg-warning"><?=$row['client_company']?></span>
				</div>
			    <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">Start Date:</span>
                      <span class="direct-chat-timestamp float-right"><?php echo date("Y-m-d",strtotime($row['start_date'])) ?></span>
                    </div>
				</div>
				<div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">End Date:</span>
                      <span class="direct-chat-timestamp float-right"><?php echo date("Y-m-d",strtotime($row['end_date'])) ?></span>
                    </div>
				</div>
              </div>
              <!-- /.card-body -->
			  <div class="card-footer">
                <span title="" class="badge bg-primary">
					<?php if($row['status'] == 'Pending'){
							echo "<span class='badge badge-warning'>".$row['status']."</span>";
						}else if($row['status'] == 'Completed'){
							echo "<span class='badge badge-success'>".$row['status']."</span>";
						}else if($row['status'] == 'In Progress'){
							echo "<span class='badge badge-info'>".$row['status']."</span>";
						}else if($row['status'] == 'Canceled'){
							echo "<span class='badge badge-danger'>".$row['status']."</span>";
						}else if($row['status'] == 'Open'){
							echo "<span class='badge badge-primary'>".$row['status']."</span>";
						}
                    ?>
				</span>
              </div>
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
			<?php } ?>
        </div>
		
		
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
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
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
  
  //Delete Project
  function delete_project(project_id){
	  var result = confirm("Want to delete?");
	  if (result) {
		var method = "delete_project";
		var data = "method="+method + "&project_id="+project_id;
	  
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
  
  //editor textarea
  $(function () {
  // Summernote
  $('.summernote').summernote()
  });
</script>
</body>
</html>
