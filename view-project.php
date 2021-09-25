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

if(isset($_GET['id'])){
	$project_id = $_GET['id'];
}

//fetching project details
try{
	$query = $con->prepare("SELECT * FROM projects WHERE project_id = :project_id");
	$query->execute(array(':project_id'=>$project_id));
	$row2 = $query->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
	echo $e->getMessage();
}
?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DCMA | View Project</title>

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
  <?php $url = "/view-project.php"; include('sidebar.php');?>
  
  <!--Data Modal For New Productivity-->
  <div class="modal fade" id="modal-lg" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Productivity</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="productivity_form">
				<div class="row">
				  <input type="hidden" id="projectid" value="<?=$project_id?>" class="form-control form-control-sm">
				  <input type="hidden" id="username" value="<?=$_SESSION['firstname']?>" class="form-control form-control-sm">
				  <div class="form-group col-md-6">
					<label for="task_no">Task No.(Select Task)</label>
					<select id="task_no" name="task_no" class="form-control form-control-sm custom-select" required>
						<option selected disabled>Select one</option>
						<?php
						$result=$con->prepare("SELECT task_no FROM tasks WHERE project_id = :project_id order by task_no ASC");
						$result->execute(array(':project_id'=>$project_id));
						while($row = $result->fetch(PDO::FETCH_ASSOC)) { 
							echo "<option value='$row[task_no]'>$row[task_no]</option>"; 
						} 
						?> 
                    </select>
				  </div>
				  <div class="form-group col-md-6">
					<label for="date">Date</label>
					<input type="date" id="date" name="date" class="form-control form-control-sm">
				  </div>
				  <div class="form-group col-md-6">
					<label for="start_time">Start Time</label>
					<input type="time" id="start_time" name="start_time" class="form-control form-control-sm">
				  </div>
				  <div class="form-group col-md-6">
					<label for="end_time">End Time</label>
					<input type="time" id="end_time" name="end_time" class="form-control form-control-sm">
                  </div>
				  <div class="form-group col-md-12">
					<label for="description">Description</label>
					<textarea id="description" name="description" class="form-control form-control-sm" rows="4"></textarea>
				  </div>
				</div>
			  </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id="save_productivity" class="btn btn-primary">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	  <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Project Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">Home</li>
			  <li class="breadcrumb-item"><a href="manage-project.php">Manage Project</a></li>
              <li class="breadcrumb-item active"><a href="#">Project Details</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
	</section>  
	  
	  
	  
	<!-- Main content -->
    <section class="content">  
	  <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Projects Detail</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-5 order-2 order-md-1">
              <div class="row">
                <div class="col-12 col-sm-6">

                
                <p class="text-sm text-muted">Project Number
                  <b class="d-block"><?=$row2['project_number']?></b>
                </p>
				<p class="text-sm text-muted">Client Company
                  <b class="d-block"><?=$row2['client_company']?></b>
                </p>
				
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Start Date</span>
                      <span class="info-box-number text-center text-muted mb-0"><?=$row2['start_date']?></span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
				  <p class="text-sm text-muted">Project Name
                    <b class="d-block"><?=$row2['project_name']?></b>
                  </p>
				  <p class="text-sm text-muted">Project Status
					<b class="d-block"><span class="badge badge-primary"><?=$row2['status']?></span></b>
                  </p>
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">End Date</span>
                      <span class="info-box-number text-center text-muted mb-0"><?=$row2['end_date']?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-12 col-lg-7 order-1 order-md-2">
              <h3 class="text-primary"><i class="fas fa-paint-brush"></i> Description</h3>
              <p class="text-muted"><?=html_entity_decode($row2['description'])?></p>
              
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    
      
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable with minimal features & hover style</h3>
				<div class="card-tools">
				  <a href="add-task.php?project_id=<?=$project_id?>" class="btn btn-sm btn-success float-right">New Task</a>
			    </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-sm table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Task No.</th>
                    <th>Task Name</th>
                    <th>Assigned</th>
					<th>Priority</th>
					<th>Status</th>
					<th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php 
				  $i=1;
				  $stmt = $con->prepare("SELECT * FROM tasks WHERE project_id = :project_id order by task_id DESC");
				  $stmt->execute(array(':project_id' => $project_id));
				  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {?> 
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
					<td><?=$row['assigned']?></td>
					<td class="project-state">
                        <span class="badge badge-<?=$priority_badge?>"><?=$row['task_priority']?></span>
                    </td>
					<td class="project-state">
                        <span class="badge badge-<?=$status_badge?>"><?=$row['task_status']?></span>
                    </td>
                    <td class="text-center">
					  <div class="btn-group">
						<a href="update-task.php?tsk_id=<?=$row['task_id']?>"  class="btn btn-default btn-flat">
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
          
	  
	  
	  <div class="card">
        <div class="card-header">
          <h3 class="card-title">Recent Activity</h3>
		  
          <div class="card-tools">
			<button class="btn btn-primary bg-gradient-success btn-sm" type="button" data-toggle="modal" data-target="#modal-lg" id="new_productivity"><i class="fa fa-plus"></i> New Productivity</button>
			<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
		
                <div id="productivity-data">
                  <!--<h4>Recent Activity</h4>-->
                    
                </div>
		
		</div>
	  </div>
	  <br>
	  
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
  
  
  
  //Productivity
  $(document).ready(function(){
	  //load productivity
	  function loadProductivity(){
		  var projectid = $('#projectid').val();
		  $.ajax({
			  url:"insert.php",
			  type:"POST",
			  data:{loadProductivity:'Yes', project_id:projectid},
			  success: function(data){
				  $('#productivity-data').html(data);
			  }
		  });
	  }
	  loadProductivity();
	  
	  //Insert Productivity
	  $('#save_productivity').on('click', function(){
		  var username = $('#username').val();
		  var projectid = $('#projectid').val();
		  var task_no = $('#task_no').val();
		  var date = $('#date').val();
		  var start_time = $('#start_time').val();
		  var end_time = $('#end_time').val();
		  var description = $('#description').val();
		  
		  if(task_no == "" || date == "" || start_time == "" || end_time == "" || description == ""){
			  toastr.error("All fields are required...");
		  }else{
			  $.ajax({
				url:"insert.php",
				type:"POST",
				data: {insertProductivity:'Yes', username:username, project_id:projectid, task_no:task_no, date:date, start_time:start_time, end_time:end_time, description:description},
				success: function(response){
					toastr.success(response);
					$('#productivity_form').trigger("reset");
					loadProductivity();
				}
			  });
		  }
		  
	  });
  });
</script>
</body>
</html>
