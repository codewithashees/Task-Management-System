<?php  
session_start();
require "init.php";

if(isset($_POST['email']) && isset($_POST['password'])){

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$email = test_input($_POST['email']);
	$password = test_input($_POST['password']);

	if(empty($email)) {
		header("Location:index.php?error=Email is Required");
	}else if(empty($password)) {
		header("Location:index.php?error=Password is Required");
	}else{

		// Hashing the password
		//$password = md5($password);
    $stmt = $con->prepare("SELECT * FROM users WHERE binary email= :email AND binary password= :password");
	$stmt->execute(array(':email' => $email, ':password' => $password));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if($stmt->rowCount()>0){
    	
    	$_SESSION['firstname'] = $row['firstname'];
    	$_SESSION['user_id'] = $row['user_id'];
    	$_SESSION['role'] = $row['role'];
    	$_SESSION['email'] = $row['email'];
    	$_SESSION['login'] = 'yes';
    	
      if($row['role'] == 'admin'){
        header("refresh:1; admin-dashboard.php");
      }else if($row['role'] == 'user'){
        header("location:user-dashboard.php");
      }

    }else{
    	header("Location:index.php?error=Invalid Email or Password");
    }
	}	
}
?>