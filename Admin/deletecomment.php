<?php

// TO SET UP CONNECTION WITH dbconnection.php
include('../dbconnection.php');
//To start or resume existing session.
session_start();
if (isset($_GET['Del'])) {

    $CID = $_GET['Del'];
    $query = "DELETE FROM comment_db WHERE c_id = '$CID'";
    $result = mysqli_query($conn, $query);   
    header("Location: comments.php");

}
?>