<?php
 // To SetUp the Connection In dbconnection.php Page.
 include ('dbconnection.php');
 // Condition to not run the code as it refreshes but to run it when the user clicks the button.
if (isset ($_REQUEST ['rSignup'])){
  //Checkin Empty fields.
  //OR If the form is empty, the INSERT row should not run.
  //OR(Condition to check if the field is empty then it does not runs & if it does it does.)
  //OR checks if its empty and does not INSERT it in DATABASE.
  if (($_REQUEST['rName'] == "")  ||
   ($_REQUEST['rEmail'] == "") || 
   ($_REQUEST['rPassword'] == "") || 
   ($_REQUEST['rSelect'] == "")){
    // To alert the USERS that all fields are required.
    $regmsg = '<div class = "alert text-center mt-2 row" style = "color: #fff; background-color:#5777ba;" role="alert" >All Fields are Required.</div>';
  } else {
    // Assingning User's Values to Variables.
    //OR SQL QUERY to Check or match in the r_email column that if it is in the userregistration_db ; if yes,  then  it will say it registered.
    $sql = "SELECT r_email FROM userregistration_db WHERE r_email = '".$_REQUEST ['rEmail']."'";
    $result = $conn->query ($sql);
    if ($result->num_rows == 1){
    //Alert the user with the message Email Already Registered.
      $regmsg =  '<div class = "alert text-center mt-2 row" style = "color: #fff; background-color:#5777ba;" role="alert" >Email ID Already Registered. Use Another Email.</div>';
    } else {
    // DATA
     $rName = $_REQUEST['rName'];
     $rEmail = $_REQUEST['rEmail'];
     $rPassword = $_REQUEST['rPassword'];
     $rSelect = $_REQUEST['rSelect'];
     $sql = "INSERT INTO userregistration_db(r_name, r_email, r_password, r_select) VALUES('$rName', '$rEmail', '$rPassword', '$rSelect')";
     //SQL connection & to alert the USER if their Account is successfull or not.
    if( $conn->query ($sql) == TRUE){
      $regmsg =  '<div class = "alert text-center mt-2 row" style = "color:#fff; background-color:#5777ba;" role = "alert" >Account Successfully Created.</div>';
    } else {
      $regmsg = '<div class = "alert text-center mt-2 row" style = "color:#fff; background-color:#5777ba;" role= "alert">Unable to Create Account.</div>';
      }
    }
  }
}
 ?>
 
 
 <!--======= Registration Form Section ======= -->
 <section id="form" class="form">
      <div class="container pt-5">
       <h2 style="color: #5777ba;" class="text-center">Create An Account</h2>
        <div class="row mt-4 mb-4">
         <div class="col-md-6 offset-md-3">
          <form action="" method="POST">
            <div class="form-group ">  
              <input type="text" class="form-control pl-2" placeholder="Name" name="rName">
            </div>
            <div>
            <input type="email" class="form-control pl-2" placeholder="Email" name="rEmail">
            </div>
            <div>
            <input type="password" class="form-control pl-2 " style="margin-top:16px;" placeholder="Password" name="rPassword">
            </div>
            <div class="form-group">
                    <!--<label for="inputRequestSelect">Choose From</label>-->
                  <select class="form-control pl-2" style="margin-top:16px;" data-style="btn-primary" name="rSelect">
                       <option>Select any one..</option>
                       <option value="user">User</option>
                       <option value="developer">Developer</option>
                       <option value="project manager">Project Manager</option>  
                  </select> 
            </div>
            <div class="text-center"><button type="submit" class="btn mt-5" name = "rSignup"> Sign Up</button></div>
            <div class="text-center "><a href ="UserLogin.php" title="Click To Log As User" class="btn mt-5 userbutton" style="color:#5777ba;background:#fff; border: 2px solid #5777ba;border-radius:25px;">Sign In As User</a></div>

            <?php if(isset($regmsg)) {
              echo $regmsg;
             }
            ?>
          </form>
         </div>
        </div>
      </div>
    </section>
    <!--======= Registration Form Section End ======= -->