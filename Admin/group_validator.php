<?php
	include('../dbconnection.php');
	//require_once '../dbconnection.php';
	//$ruser = $_POST['r_user'];
	$ruser = $_POST['r_user'];
	
    $pid = $_POST['p_id'];
   
	$query = $conn->query("SELECT * FROM `new_r_login_p_id` WHERE `r_user` = '$ruser' && `p_id` = '$pid'");
	$validate = $query->num_rows;
	if($validate > 0){
		echo "Success";
	}else{
		echo "Error";
	}
	
	?>