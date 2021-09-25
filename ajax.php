<?php
$method = $_POST['method'];
$method();

//Validation Function
function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

//fetching user details
function fetch_user_data(){
	require "init.php";
	$user_id = $_POST['user_id'];
	
	$result = $con->prepare("SELECT * FROM users WHERE user_id = ? ");
	$result->execute(array($user_id));
	while($row = $result->fetch(PDO::FETCH_ASSOC)){
		$output = $row;
	}
	echo json_encode($output);
}

//updating user details
function update_user_info(){
	require "init.php";
	
	$user_id = $_POST['user_id'];
	
	
	$firstname = test_input($_POST['firstname']);
	$lastname = test_input($_POST['lastname']);
	$email = test_input($_POST['email']);
	$password = test_input($_POST['password']);
	$role = test_input($_POST['role']);
	$status = test_input($_POST['status']);
	
	try{
		$sql = $con->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, password = :password, role = :role, status = :status WHERE user_id = :user_id");
		$sql->execute(array(':firstname'=>$firstname,':lastname'=>$lastname,':email'=>$email,':password'=>$password,':role'=>$role,':status'=>$status,':user_id'=>$user_id));
		
		echo "Record Updated Successfully";
		
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	
}

//delete user
function delete_user(){
	require "init.php";
	$user_id = $_POST['user_id'];
	try{
		$sql = $con->prepare("DELETE FROM users WHERE user_id = ?");
		$sql->execute(array($user_id));
		echo "Successfully deleted";
	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//Delete Task
function delete_task(){
	require "init.php";
	$task_id = $_POST['task_id'];
	try{
		$sql = $con->prepare("DELETE FROM tasks WHERE task_id = ?");
		$sql->execute(array($task_id));
		echo "Successfully deleted";
	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//update project details
function update_project_details(){
	require "init.php";
	
	$project_id = $_POST['projectid'];
	
	$project_number = test_input($_POST['project_number']);
	$project_name = test_input($_POST['project_name']);
	$client_company = test_input($_POST['client_company']);
	$start_date = test_input($_POST['start_date']);
	$end_date = test_input($_POST['end_date']);
	$status = test_input($_POST['status']);
	$description = htmlentities(str_replace("'","&#x2019;",$_POST['description']));
	
	try{
		$sql = $con->prepare("UPDATE projects SET project_name=:project_name, client_company=:client_company, start_date=:start_date, end_date = :end_date, status=:status, description=:des WHERE project_id=:project_id");
		$sql->execute(array(':project_name'=>$project_name,':client_company'=>$client_company,':start_date'=>$start_date,':end_date'=>$end_date,':status'=>$status,':des'=>$description,':project_id'=>$project_id));
		echo "Record Updated Successfully";
	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//Delete Project
function delete_project(){
	require "init.php";
	$project_id = $_POST['project_id'];
	
	try{
		$sql = $con->prepare("DELETE FROM projects WHERE project_id = ?");
		$sql->execute(array($project_id));
		echo "Successfully deleted";
	}catch(PDOException $e){
		echo $e->getMessage();
	}
}


// Save todo Task
function save_todo_task(){
	require "init.php";
	$user_id = test_input($_POST['user_id']);
	$task_name = test_input($_POST['task_name']);
	$status = test_input($_POST['status']);
	$priority = test_input($_POST['priority']);
	$due_date = test_input($_POST['due_date']);
	$notes = test_input($_POST['notes']);
	
	try{
		$sql = $con->prepare("INSERT INTO todos(user_id,task_name,status,priority,due_date,notes)VALUES(?,?,?,?,?,?)");
		$sql->execute(array($user_id,$task_name,$status,$priority,$due_date,$notes));
		echo "Task Added";
	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//fetching/Show todo
function show_todo_data(){
	require "init.php";
	$todo_id = $_POST['todo_id'];
	
	$result = mysqli_query($con, "SELECT * FROM todos WHERE todo_id = '$todo_id'");
	
	while($row = mysqli_fetch_assoc($result)){
		$output = $row;
	}
	echo json_encode($output);
}

//update todo task
function update_todo_task(){
	require "init.php";
	
	$todoid = $_POST['todoid'];
	
	$task_name = test_input($_POST['task_name']);
	$status = test_input($_POST['status']);
	$priority = test_input($_POST['priority']);
	$due_date = test_input($_POST['due_date']);
	$notes = test_input($_POST['notes']);
	
	try{
		$sql = $con->prepare("UPDATE todos SET task_name=:task_name, status=:status, priority=:priority, due_date = :due_date, notes=:notes WHERE todo_id=:todoid");
		$sql->execute(array(':task_name'=>$task_name,':status'=>$status,':priority'=>$priority,':due_date'=>$due_date,':notes'=>$notes,':todoid'=>$todoid));
		echo "Record Updated Successfully";
		
	}catch(PDOException $e){
		echo $e->getMessage();
	}
}

//Delete todo Task
function delete_todo_task(){
	require "init.php";
	$todo_id = $_POST['todo_id'];
	
	try{
		$sql = $con->prepare("DELETE FROM todos WHERE todo_id = ?");
		$sql->execute(array($todo_id));
		echo "Successfully deleted";
	}catch(PDOException $e){
		echo $e->getMessage();
	}
}
?>