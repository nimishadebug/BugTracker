<?php
include('../dbconnection.php');
session_start();
$userid = $_SESSION["r_login_id"];
mysqli_query($conn,"UPDATE new_r_login_p_id set status_user = 1 where r_user = $userid");
?>