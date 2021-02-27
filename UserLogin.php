<?php
// TO SET UP CONNECTION WITH dbconnection.php
include ('dbconnection.php');
//To start or resume existing session.
session_start();

if(isset($_POST['login'])) 
{
 $_SESSION['login'] = true; 
 $rEmail  =$_POST["rEmail"]; 
 $rPassword =$_POST["rPassword"]; 
 $rSelect  =$_POST["rSelect"];  

 $query = "SELECT r_login_id, r_name, r_email, r_password, r_select FROM userregistration_db WHERE r_email = '".$rEmail."' AND 
           r_password = '".$rPassword."' AND r_select = '".$rSelect."'";

 $result = mysqli_query($conn, $query);
 if($result->num_rows == 1){
  $_SESSION['login'] = true;
  $_SESSION['rEmail'] = $rEmail;
  $_SESSION['rPassword'] = $rPassword;
  $_SESSION['rSelect'] = $rSelect;

   while($row = mysqli_fetch_array($result)){
      $userid = $row['r_login_id'];
     echo'<script type="text/javascript">alert("you have logged in successfully as '.$row['r_select'].'")</script>';
   }

    session_regenerate_id();
    $_SESSION['r_login_id'] = $userid;
    session_write_close();

   if($rSelect=="user"){
     ?>
     <script type="text/javascript">location.href = "User/UserDashboard.php"</script>
     <?php
     }else if($rSelect=="admin"){
       ?>
       <script type="text/javascript">location.href = "Admin/AdminDashboard.php"</script>
       <?php 
    }else if($rSelect=="developer"){
       ?>
       <script type="text/javascript">location.href = "Developer/DeveloperDashboard.php"</script>
       <?php 
     }else if($rSelect=="project manager"){
       ?>
       <script type="text/javascript">location.href = "ProjectManager/ProjectManagerDashboard.php"</script>
       <?php
     } 
   } else {
      echo 'no result';
   }           
  
}
?>


  

<!--HTML Starts-->
<!DOCTYPE html>
<html lang = "en">
<head>
  <meta name = "viewport" content = "width=device-width,initial-scale=1.0";>
  <meta http-equip= "X-UA-Compatible" content= "ie-edge">

  <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/main.css">

  <!-- Main CSS File -->
 
<title>Login</title>
</head>
<body>
<!--navbar-menu ends-->
<header id="header" class="fixed-top">
    <div class="container d-flex">
      <div class="logo mr-auto">
        <h1 class="text-light"><a href="index.php">Bug Tracker</a></h1>
      </div>
      <!--nav bar starts-->
      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="index.php">Home</a></li>
          <li><a href="index.php"> Features</a></li>
          <li><a href="UserLogin.php">Login </a></li>
          <li><a href="index.php"> Contact </a></li>
        </ul>
      </nav><!--nav ends-->  
    </div>
  </header>
  
<!-- .nav-menu ends-->
<!-- Footer Start-->
<section id="hero" class=" align-items-center">
  <div class="text-center justify-content-center" style="font-size:30px; color:#5777ba;">
  <span>Bug Tracker Management System</span>
  </div>
  <p class="text-center" style="font-size:20px; color:#5777ba;">User Area</p>
  <div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-sm-6 col-md-4 mt-5">
     <form action="" method="POST">
       <div class="form-group">
         <input type="email" class="form-control pl-2" placeholder="Email" name="rEmail">
         </div>  
         <div>
         <input type="password" class="form-control pl-2" placeholder="Password" name="rPassword">
       </div>
       <!--Select From-->
       <div class="form-group">
                    <!--<label for="inputRequestSelect">Choose From</label>-->
                  <select class="form-control pl-2" style="margin-top:16px;" data-style="btn-primary" name="rSelect">
                       <option>Select any one..</option>
                       <option value="admin">Admin</option>
                       <option value="user">User</option>
                       <option value="developer">Developer</option>
                       <option value="project manager">Project Manager</option>  
                  </select> 
            </div> 
        

       <div class="text-center"><button type="submit" class="btn mt-3" name="login">Login</button></div> 
       <?php if(isset($msg))
        {
        echo $msg;
        }
        ?>
     </form>
    </div>
  </div>
  </div>
  </section>
<!--Footer Ends-->
  <!--Footer Start-->
  <footer id="footer">
  <div class="container py-4">
      <div class="copyright">
        &copy; Copyright <strong><span>BugTracker</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed to Track Bug<a href="index.php"></a>
      </div>
    </div>
  </footer>
  <!-- End Footer -->
<!-- Javascript script starts-->
<script>
//This code is used so that the browser does not shows" Confirm Form Resubmission. The page that you're looking for used information that you entered. Returning to that
//page might cause any action you took to be repeated. Do you want to continue" ?
  if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!--script ends-->
</body>
</html>



