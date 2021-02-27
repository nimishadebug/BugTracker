<?php

// TO SET UP CONNECTION WITH dbconnection.php
include('../dbconnection.php');
//To start or resume existing session.
session_start();
if (isset($_GET['Del'])) {

    $CID = $_GET['Del'];
    $query = "DELETE FROM submitrequest_db WHERE request_id = '$RID'";
    $result = mysqli_query($conn, $query);   
    header("Location: detailticket.php");

}
?>