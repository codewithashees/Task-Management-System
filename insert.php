<?php
//Insert Productivity
if(isset($_POST['insertProductivity'])){
	
	require "init.php";
	
	$username = $_POST['username'];
	$project_id = $_POST['project_id'];
	$task_no = $_POST['task_no'];
	$date = $_POST['date'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	$description = $_POST['description'];
	
	try{
		
		$sql = "INSERT INTO user_productivity(user_name, project_id, task_no, date, start_time, end_time, description)VALUES(?,?,?,?,?,?,?)";
		$stmt = $con->prepare($sql);
		$stmt->execute(array($username,$project_id,$task_no,$date,$start_time,$end_time,$description));
		
		echo "Success";
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	
}

//Load Productivity
if(isset($_POST['loadProductivity']) and $_POST['loadProductivity']=='Yes'){
	
	require "init.php";
	
	$project_id = $_POST['project_id'];

	$sql = $con->prepare("SELECT * FROM user_productivity WHERE project_id = ? ORDER BY id DESC");
	$sql->execute(array($project_id));
	
	$output = "";
	if($sql->rowCount() > 0){
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
			$output .= '<div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="dist/img/avatar.jpg" alt="user image">
                        <span class="username">
                          <a href="#">'.$row["user_name"].'</a>
                        </span>
						<span class="description">
		                  	<span class="fa fa-calendar-day"></span>
		                    <span><b>'.$row['date'].'</b></span>
		                    <span class="fa fa-user-clock"></span>
							<span>Start: <b>'.$row['start_time'].'</b></span>
		                    <span> | </span>
							<span>End: <b>'.$row['end_time'].'</b></span>
	                    </span>
                        <span class="description">Task No. - <b>'.$row['task_no'].'</b></span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        '.$row['description'].'
                      </p>
                    </div>';
		}
		$con = null;
		echo $output;
		
	}else{
		echo '<h2>No Record Found...</h2>';
	}
	
	
}


//Load Task Activity
if(isset($_POST['loadActivity']) and $_POST['loadActivity']=='Yes'){
	
	require "init.php";
	
	$task_no = $_POST['task_no'];

	$sql = $con->prepare("SELECT * FROM task_activity WHERE task_no = ? ORDER BY id DESC");
	$sql->execute(array($task_no));
	$output = "";
	if($sql->rowCount() > 0){
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
			
			$output .= '<div style="border:none;" class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="dist/img/avatar.jpg" alt="user image">
                        <span class="username">
                          <a href="#">'.$row["user_name"].'</a>
                        </span>
						<span class="description">
		                  	<span class="fa fa-calendar-day"></span>
		                    <span><b>'.$row['datetime'].' ['.$row["task_no"].']</b></span>
	                    </span>
                        <span class="description">
						Task Name: <b>'.$row['task_name'].'</b> to <b>'.$row['u_taskname'].'</b>
						<span>|</span>
						Assign To: <b>'.$row['assign_to'].'</b> to <b>'.$row['u_assignto'].'</b>
						<span>|</span>
						Priority: <b>'.$row['task_priority'].'</b> to <b>'.$row['u_priority'].'</b>
						<span>|</span>
						Status: <b>'.$row['task_status'].'</b> to <b>'.$row['u_status'].'</b>
						</span>
						<p>
                        <b>Update Note:</b> '.$row['task_update_note'].'
						</p>
                      </div>
                      <!-- /.user-block -->
                      
                    </div>';
		}
		$con = null;
		echo $output;
		
	}else{
		echo '<h2>No Record Found...</h2>';
	}
	
	
}
?>