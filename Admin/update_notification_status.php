<?php
include('../dbconnection.php');
session_start();
$userid = $_SESSION["r_login_id"];
mysqli_query($conn,"UPDATE submitrequest_db set admin_ticket_status = 1");
?>