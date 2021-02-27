<?php
    include('../dbconnection.php');
    //require_once '../dbconnection.php';
    //$ruser = $_POST['r_user'];
    $ruser = $_POST['r_user'];
    
    $pid = $_POST['p_id'];
    
    //$conn->query("INSERT INTO `new_r_login_p_id`(p_id,r_developer, r_pmanager, r_user) VALUES('$pid', '$r_developer', '$r_pmanager', '$ruser')");
    $conn->query("INSERT INTO `new_r_login_p_id` VALUES ('', '$pid', '$rpmanager')");
     //$query = "INSERT INTO 'new_r_login_p_id' VALUES('', '$pid', '$ruser')";
     
     //$resultS = $conn->query($query);
	//if($validate > 0){
        
?>