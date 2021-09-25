<?php
session_start();
$user_id = $_SESSION['user_id'];
if(isset($_POST['method'])){
	require "init.php";
	$result = $con->prepare("SELECT * FROM todos WHERE user_id = ? AND status = 'Pending' order by todo_id DESC limit 5");
	$result->execute(array($user_id));
		$j = 1;
		$k = 1;
	while($row = $result->fetch(PDO::FETCH_ASSOC)){
		$output = "";
		
		$output .= '
			<li class="'.$row['css_class'].'">
			<span class="handle ui-sortable-handle">
				<i class="fas fa-ellipsis-v"></i>
				<i class="fas fa-ellipsis-v"></i>
			</span>
			<div class="icheck-primary d-inline ml-2">
				<input class="todo_check" type="checkbox" onclick="check(this, '.$row['todo_id'].');" id="todoCheck'.$j++.'">	
				<label for="todoCheck'.$k++.'"></label>
			</div>
			<span class="text">'.$row['task_name'].'</span>
			<small class="badge badge-info"><i class="far fa-clock"></i> '.$row['datetime'].'</small>
			<div class="tools">
				<i class="fas fa-edit"></i>
				<i class="fas fa-trash-o"></i>
			</div>
			</li>
		';
		echo $output;
	}
}

//check
if(isset($_POST['action'])){
	require "init.php";
	$tsk_id = $_POST['value'];
	
	try{
		$query = $con->prepare("UPDATE todos SET css_class = 'done', status = 'Completed' WHERE todo_id = ?");
		$query->execute(array($tsk_id));
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	
}
//uncheck
if(isset($_POST['uncheck'])){
	require "init.php";
	$tsk_id = $_POST['value'];
	
	try{
		$query = $con->prepare("UPDATE todos SET css_class = '', status = 'Pending' WHERE todo_id = ?");
		$query->execute(array($tsk_id));
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	
}

?>