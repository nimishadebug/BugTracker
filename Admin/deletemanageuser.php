<?php
// TO SET UP CONNECTION WITH dbconnection.php
include('../dbconnection.php');
$p_id = $_REQUEST['p_id'];
if(isset($_GET['r_id'])) {
    $r_id = $_GET['r_id'];
    $query = "DELETE FROM r_login_p_id WHERE r_id = '$r_id';";
    $result = mysqli_query($conn, $query);  
    header("Location: MyProject.php");
    //header("Location: projectdetail.php?Detail=4");  

} 
 //echo $r_id;
?>

