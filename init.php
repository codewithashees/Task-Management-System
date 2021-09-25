<?php
	
	$db_name = "mysql: host=localhost;dbname=dcma_tms";
	$username = "root";
	$password = "";
	
	try {
	  $con = new PDO($db_name, $username, $password);
	  // set the PDO error mode to exception
	  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  //echo "Connected successfully";
	} catch(PDOException $e) {
	  echo "Connection failed: " . $e->getMessage();
	}
	
    /* $con = mysqli_connect("localhost","root" ,"","dcma_tms");

    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }else{
        //echo "success";
    } */
?>