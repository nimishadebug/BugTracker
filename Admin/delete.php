<?php

// TO SET UP CONNECTION WITH dbconnection.php
include('../dbconnection.php');
//To start or resume existing session.
session_start();
if (isset($_GET['Del'])) {
    $PID = $_GET['Del'];
    $query = "DELETE FROM project_db WHERE p_id='$PID'";
    $result = mysqli_query($conn, $query);   
    header("Location: MyProject.php");
}

?>

