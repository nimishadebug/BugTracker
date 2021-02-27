<?php

// TO SET UP CONNECTION WITH dbconnection.php
include('../dbconnection.php');
//To start or resume existing session.
session_start();
if (isset($_GET['Del'])) {

    $RID = $_GET['Del'];
    $query = "DELETE FROM new_r_login_p_id WHERE r_id = '$RID'";
    $result = mysqli_query($conn, $query);   
    header("Location: group.php");

}
?>