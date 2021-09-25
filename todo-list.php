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
  <title>DCMA | To Do List</title>

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
              <h4 class="modal-title">To Do List</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="" id="todo_form">
				<!--inportant field-->
				<input type="hidden" id="userid" value="<?php echo $_SESSION['user_id'] ?>" class="form-control">
				<input type="hidden" id="todoid" class="form-control">
				<!--/inportant field-->
				<div class="row">
				  <div class="form-group col-md-6">
					<label for="task_name">Task Name</label>
					<input type="text" id="task_name" name="task_name" class="form-control form-control-sm" required>
				  </div>
				  <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control form-control-sm" required>
						<option selected disabled>Select one</option>
						<option value="Pending">Pending</option>
						<option value="Completed">Completed</option>
                    </select>
                  </div>
				  <div class="form-group col-md-6">
					<label for="priority">Priority</label>
					<select id="priority" name="priority" class="form-control form-control-sm" required>
						<option selected disabled>Select one</option>
						<option value="High">High</option>
						<option value="Medium">Medium</option>
						<option value="Low">Low</option>
                    </select>
				  </div>
				  <div class="form-group col-md-6">
					<label for="due_date">Due Date</label>
					<input type="date" id="due_date" name="due_date" class="form-control form-control-sm">
				  </div>
				  <div class="col-sm-12">
                      <!-- textarea -->
                      <div class="form-group">
                        <label for="due_date">Notes</label>
                        <textarea id="notes" name="due_date" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                      </div>
                  </div>
				</div>
			  </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" id="update_h" onclick="update_todo_task()" class="btn btn-primary">Update</button>
			  <button type="button" id="save_h" onclick="save_todo_task()" data-dismiss="modal" class="btn btn-primary">Save</button>
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
  <?php $url = '/todo-list.php'; include('sidebar.php');?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My To Do List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">To Do List</li>
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
				<button style="float:right;" type="button" id="add" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-default">
                          <i class="fas fa-plus"></i>
                        </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-sm table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Task Name</th>
                    <th>Priority</th>
                    <th>Due Date</th>
                    <th>Status</th>
					<th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php 
				  $i=1;
				  $user_id = $_SESSION['user_id'];
				  $result=$con->prepare("SELECT * FROM todos WHERE user_id = ? order by todo_id DESC"); 
				  $result->execute(array($user_id));
				  while($row=$result->fetch(PDO::FETCH_ASSOC)) {?> 
				  
				  <?php
				  //status
				  if($row['status'] == "Pending"){
					  $t_status = "warning";
				  }else{
					  $t_status = "success";
				  }
				  //priority
				  if($row['priority'] == "High"){
					  $p_status = "danger";
				  }else if($row['priority'] == "Medium"){
					  $p_status = "primary";
				  }else if($row['priority'] == "Low"){
					  $p_status = "warning";
				  }
				  ?>
				  	
                  <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?=$row['task_name']?></td>
                    <td>
						<span class="badge badge-<?=$p_status?>"><?=$row['priority']?></span>
					</td>
					<td><?=$row['due_date']?></td>
					<td>
						<span class="badge badge-<?=$t_status?>"><?=$row['status']?></span>
					</td>
                    <td class="text-center">
					  <div class="btn-group">
                        <button type="button" onclick="show_todo_task(<?=$row['todo_id'];?>)" class="btn btn-default btn-flat edit_user" data-toggle="modal" data-target="#modal-default">
                          <i class="far fa-edit"></i>
                        </button>
                        <button type="button" onclick="delete_todo_task(<?=$row['todo_id'];?>)" class="btn btn-default btn-flat">
                          <i class="far fa-trash-alt"></i>
                        </button>
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
  
  //Save todo task
  function save_todo_task(){
	  //var newWindow = window.open('/tms/assigned-task.php', 'name', 'height=500,width=600');
	  var user_id = $('#userid').val();
	  var task_name = $('#task_name').val();
	  var status = $('#status').val();
	  var priority = $('#priority').val();
	  var due_date = $('#due_date').val();
	  var notes = $('#notes').val();
	  
	  var method = "save_todo_task";
	  var data = "method="+method + "&user_id="+user_id + "&task_name="+task_name + "&status="+status + "&priority="+priority + "&due_date="+due_date + "&notes="+notes;
	  
	  $.ajax({
		  cache:false,
		  url:"ajax.php",
		  type:"POST",
		  data: data,
		  success: function(response){
			  //alert(response);
			  toastr.success(response);
			  $("#todo_form")[0].reset();
			  //console.log(response);
		  }
		  
	  });
  }
  
  //showing todo task
  function show_todo_task(todo_id){
	  $("#update_h").show();
	  $("#save_h").hide();
	  
	  var method = "show_todo_data";
	  var data = "method="+method + "&todo_id="+todo_id;
	  
	  $.ajax({
		  cache:false,
		  url:"ajax.php",
		  type:"POST",
		  data: data,
		  success: function(response){
			  var json_data = JSON.parse(response);
			  $('#todoid').val(json_data.todo_id);
			  $('#task_name').val(json_data.task_name);
			  $('#status').val(json_data.status);
			  $('#priority').val(json_data.priority);
			  $('#due_date').val(json_data.due_date);
			  $('#notes').val(json_data.notes);
			  //console.log(response);
		  }
		  
	  });
  }
  
  //update todo task
  function update_todo_task(){
	  var todoid = $('#todoid').val();
	  var task_name = $('#task_name').val();
	  var status = $('#status').val();
	  var priority = $('#priority').val();
	  var due_date = $('#due_date').val();
	  var notes = $('#notes').val();
	  
	  var method = "update_todo_task";
	  var data = "method="+method + "&todoid="+todoid + "&task_name="+task_name + "&status="+status + "&priority="+priority + "&due_date="+due_date + "&notes="+notes;
	  
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
  function delete_todo_task(todo_id){
	  var result = confirm("Want to delete?");
	  if (result) {
		var method = "delete_todo_task";
		var data = "method="+method + "&todo_id="+todo_id;
	  
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
  $(document).on('click', '#add', function(){
	  $("#todo_form")[0].reset();
	  $("#update_h").hide();
	  $("#save_h").show();
  });
	  
</script>
</body>
</html>
