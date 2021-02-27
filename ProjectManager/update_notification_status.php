<?php
include('../dbconnection.php');
session_start();
$userid = $_SESSION["r_login_id"];
mysqli_query($conn,"UPDATE new_r_login_p_id set status_pmanager = 1 where r_pmanager = $userid");
?>