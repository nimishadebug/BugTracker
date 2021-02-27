<?php
include('../dbconnection.php');
session_start();
var_dump($_SESSION['login']);
echo $_SESSION['login'];
echo $_GET['pid'];
error_reporting(0);
                
if (isset($_SESSION['login'])) {
    //if true the user is logged in from the beginning.
    $rEmail = $_SESSION['rEmail'];
} else {
    //redirected. if the user tries to access the userlogin.php then he will be redirected.
    echo "<script>location.href = '../dashboard.php'</script>";
}

if (isset($_GET['pid'])) {
$pid = $_GET['pid'];
}

if (isset($_POST['insert'])) {
$rdeveloper = $_POST['projectdeveloper'];
$rpmanager = $_POST['projectmanager'];
$ruser = $_POST['projectuser'];

$sql = "INSERT INTO new_r_login_p_id(p_id,r_developer,r_pmanager,r_user)VALUES('$pid','$rdeveloper','$rpmanager','$ruser')";
$result = $conn->query($sql) or die(mysqli_error($conn));
if ($result) {
$msg = '<div class = "alert mt-4 btn-block" style = "color:#fff; background-color:#5777ba;">Submitted Successfully</div>'; //.$conn->insert_id;
} else {
$msg = '<div class = "alert mt-4 btn-block" style = "color:#fff; background-color:#5777ba;">Unable To Submit.</div>'; //(mysqli_connect_error());
}
}

if (isset($_POST['inremove'])) {
    $removedeveloper = $_POST['removedeveloper'];
    $removepmanager = $_POST['removemanager'];
    $removeuser = $_POST['removeuser'];  
    
$sqli = "DELETE FROM new_r_login_p_id WHERE p_id = '$pid' AND r_developer = '$removedeveloper' && r_pmanager = '$removepmanager' && r_user = '$removeuser'";
//$sqli = "DELETE FROM `new_r_login_p_id` WHERE `new_r_login_p_id`.`r_id` = 80";
$result =  $conn->query($sqli) or die (mysqli_error($conn));
if($result) {
    $newmsg = '<div class = "alert mt- btn-block" style = "color:#fff; background-color:#5777ba;">Deleted Successfully</div>';
}else{
    $newmsg = '<div class = "alert mt- btn-block" style = "color:#fff; background-color:#5777ba;">Unable to submit the query</div>';
}
}

?>

<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Profile - BugTracker</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <!--<script src="../assets/js/script.js"></script>-->
</head>

<body>
    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default" style="background-color: #f8f8f8;">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="nav-item" style="padding-top:15px;">
                        <a href="AdminDashboard.php"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                    </li>
                    <li class="nav-item">
                        <a href="ManageRoleAssign.php"><i class="menu-icon fa fa-user-plus"></i>Manage Role Assignment </a>
                    </li>
                    <li class="active bg-primary">
                        <a style="color: white;" href="ManageProjectUsers.php"><i style="color: white;" class="menu-icon fa fa-square"></i>Manage Project Users </a>
                    </li>
                    <li class="nav-item">
                        <a href="MyProject.php"><i class="menu-icon fa fa-tasks"></i>My Projects </a>
                    </li>
                    <li class="nav-item">
                        <a href="MyTicket.php"><i class="menu-icon fa fa-ticket"></i>My Tickets </a>
                    </li>
                    <li class="nav-item">
                        <a href="UserList.php"><i class="menu-icon fa fa-users"></i>User List </a>
                    </li>
                    <li class="nav-item">
                        <a href="comments.php"><i class="menu-icon fa fa-comment"></i>Comments </a>
                    </li>
                    <li class="nav-item">
                        <a href="ChangePassword.php"><i class="menu-icon fa fa-key"></i>Change Profile Settings </a>
                    </li>
                    <li class="nav-item" style="padding-bottom:12px;">
                        <a href="AdminLogout.php"><i class="menu-icon fa fa-arrow-right"></i>Logout </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" style="font-size: 18px; padding-left:15px; color:#337ab7" href="../index.php">Bug Tracker</a>
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="top-right" style="padding-right:15px;">
                <div class="header-menu">
                    <div class="header-left">
                        <button class="search-trigger"><i class="fa fa-search"></i></button>
                        <div class="form-inline">
                            <form class="search-form">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                            </form>
                        </div>

                        <div class="dropdown for-notification">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell"></i>
                                <span class="count bg-danger">3</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="notification">
                                <p class="red">You have 3 Notification</p>
                                <a class="dropdown-item media" href="#">
                                    <i class="fa fa-check"></i>
                                    <p>You have a new Project: Project5: React Blog.</p>
                                </a>
                                
                            </div>
                        </div>

                        <div class="dropdown for-message">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="message" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-envelope"></i>
                                <span class="count bg-primary">2</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="message">
                                <p class="red">You have 4 Mails</p>
                                <a class="dropdown-item media" href="#">
                                    <span class="photo media-left"><img alt="#" src="#"></span>
                                    <div class="message media-body">
                                        <span class="name float-left">Jonathan Smith</span>
                                        <span class="time float-right">Just now</span>
                                        <p>Hello, this is an example msg</p>
                                    </div>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <span class="photo media-left"><img alt="#" src="#"></span>
                                    <!--<span class="photo media-left"><img alt="avatar" src="images/avatar"></span>-->
                                    <div class="message media-body">
                                        <span class="name float-left">Jack Sanders</span>
                                        <span class="time float-right">5 minutes ago</span>
                                        <p>Lorem ipsum dolor sit amet, consectetur</p>
                                    </div>
                                </a>
                               
                            </div>
                        </div>
                    </div>

                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="../assets/img/images1.png" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa- user"></i>My Profile</a>

                            <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">13</span></a>

                            <a class="nav-link" href="#"><i class="fa fa -cog"></i>Settings</a>

                            <a class="nav-link" href="#"><i class="fa fa-power -off"></i>Logout</a>
                        </div>
                    </div>

                </div>
            </div>
        </header>
        <!-- /#header -->

        <!-- Content Starts-->

        <div class="content" style="background-color: white;">
            <div class="card" style="color:#5777ba;">

                <?php
                $c_query = $conn->query("SELECT * FROM `project_db` WHERE `p_id` = '$_GET[pid]'");
                $c_fetch = $c_query->fetch_array();
                $project = $c_fetch['p_id'];
                ?>

                <div class="card-header bg-primary text-center" style="color:white;"><?php echo $c_fetch['p_name'] ?> / USERLIST</div>

                <div class="row mx-5 text-center">

                    <div class="col-sm-4 text-white text-center mt-5">
                        <div class="card box p-2 text-white mb-3">
                            <div class="card-header bg-primary text-white">Developer(s)</div>
                            <div class="card-body">
                                <form id="form" method="POST">
                                    <div class="form-group" style="color:#5777ba;">
                                        <label for="projectdeveloper" style="color:#5777ba;">Choose any one:</label>

                                        <select class="form-control chosen-select" data-style="btn-primary" aria-describedby="projectdeveloper" name="projectdeveloper">
                                            <option value="option">Select a member</option>

                                            <?php
                                            $sqli = mysqli_query($conn, "SELECT r_login_id, r_name FROM userregistration_db WHERE r_select = 'developer'");
                                            while ($row = mysqli_fetch_array($sqli)) {
                                                echo "<option value=" . $row['r_login_id'] . ">" . $row['r_name'] . "</option>";
                                            }
                                            ?>

                                        </select>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 text-white text-center mt-5">
                        <div class="card box p-2 text-white mb-3">
                            <div class="card-header bg-primary text-white">Manager(s)</div>
                            <div class="card-body">
                                <div class="form-group" style="color:#5777ba;">
                                    <label for="projectmanager" style="color:#5777ba;">Choose any one:</label>

                                    <select class="form-control chosen-select" data-style="btn-primary" aria-describedby="projectmanager" name="projectmanager">
                                        <option value="option">Select a member</option>

                                        <?php
                                        $sqli = mysqli_query($conn, "SELECT r_login_id, r_name FROM userregistration_db WHERE r_select = 'project manager'");
                                        while ($row = mysqli_fetch_array($sqli)) {
                                            echo "<option value=" . $row['r_login_id'] . ">" . $row['r_name'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 text-white text-center mt-5">
                        <div class="card box p-2 text-white mb-3">
                            <div class="card-header bg-primary text-white">User(s)</div>
                            <div class="card-body">
                                <div class="form-group" style="color:#5777ba;">
                                    <label for="projectuser" style="color:#5777ba;">Choose any one:</label>

                                    <select class="form-control chosen-select" data-style="btn-primary" aria-describedby="projectuser" name="projectuser">
                                        <option value="option">Select a member</option>

                                        <?php
                                        $sqli = mysqli_query($conn, "SELECT r_login_id, r_name FROM userregistration_db WHERE r_select = 'user'");
                                        while ($row = mysqli_fetch_array($sqli)) {
                                            echo "<option value=" . $row['r_login_id'] . ">" . $row['r_name'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                                               
                    <div class="col-sm-12 mb-5">
                        <input name="insert" class="btn btn-primary btn-large btn-block" type="submit" value="Add User(s)">
                    </div>
                    </form>
                    <?php
                     if (isset($msg)) {
                    echo $msg;
                    }
                    ?>
                </div>
            </div>

            <div class="newcontent" style="background-color: white;margin-bottom:72px;">
                <div class="card" style="color:#5777ba;">
                    <div class="row mx-5 text-center">
                        <div class="col-sm-4 text-white text-center mt-5">
                            <div class="card box p-2 text-white mb-3">
                                <div class="card-header bg-primary text-white">Developer(s)</div>
                                <form id="form" method="POST">
                                <div class="card-box">
                                    <div id="wrapper" style="width:280px;padding:16px;height:110px;">
                                    <div class="form-group">
                                        <select name="removedeveloper" class="form-control" multiple="multiple">

                                            <?php

                                            $sql = "SELECT new_r_login_p_id.p_id, new_r_login_p_id.r_developer, userregistration_db.r_login_id,
                                             userregistration_db.r_name FROM new_r_login_p_id, userregistration_db WHERE 
                                             new_r_login_p_id.r_developer = userregistration_db.r_login_id AND p_id = '$pid'";

                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value=" . $row['r_login_id'] . ">" . $row['r_name'] . "</option>";
                                            }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 text-white text-center mt-5">
                            <div class="card box p-2 text-white mb-3">
                                <div class="card-header bg-primary text-white">Manager(s)</div>
                                <div class="card-box">
                                    <div id="wrapper" style="width:280px;padding:16px;height:110px;">
                                    <div class="form-group">

                                        <select name="removemanager" class="form-control" multiple="multiple">

                                            <?php

                                            $sql = "SELECT new_r_login_p_id.p_id, new_r_login_p_id.r_pmanager, userregistration_db.r_login_id,
                                            userregistration_db.r_name FROM new_r_login_p_id, userregistration_db WHERE new_r_login_p_id.r_pmanager = userregistration_db.r_login_id
                                            AND p_id = '$pid'";

                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value=" . $row['r_login_id'] . ">" . $row['r_name'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 text-white text-center mt-5">
                            <div class="card box p-2 text-white mb-3">
                                <div class="card-header bg-primary text-white">User(s)</div>
                                <div class="card-box">
                                    <div id="wrapper" style="width:280px;padding:16px;height:110px;">
                                    <div class="form-group">
                                        <select name="removeuser" class="form-control" multiple="multiple">

                                            <?php

                                            $sql = "SELECT new_r_login_p_id.p_id, new_r_login_p_id.r_user, userregistration_db.r_login_id,
                                            userregistration_db.r_name FROM new_r_login_p_id, userregistration_db WHERE new_r_login_p_id.r_user = userregistration_db.r_login_id
                                             AND p_id = '$pid'";

                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value=" . $row['r_login_id'] . ">" . $row['r_name'] . "</option>";
                                                    
                                                }
                                            }

                                            ?>
                                        </select>

                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <input name="inremove" type="submit"class="btn btn-primary btn-block" value="Remove User(s)">
                        </div>
                        </form>
                        <?php
                        if (isset($newmsg)) {
                         echo $newmsg;
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /*.content*/ -->
    <!-- Footer -->
    <footer class="site-footer " style="position:fixed;bottom:0;right:0;left:0;background:#eff2f8;">
        <div class="footer-inner">
            <div class="row" style="display:flex;">
                <div class="col-sm-12 text-center">Copyright &copy; Bug Tracker:Designed by <a href=#>Nimisha Dubey</a></div>
            </div>
        </div>
    </footer>
    <!-- /.site-footer -->

    <!--content ends here-->

    <!-- /#right-panel -->
    <!--This code is used so that the browser does not shows" Confirm Form Resubmission. The page that you're looking for used information that you entered. Returning to that
     page might cause any action you took to be repeated. Do you want to continue" ? -->


    <!-- Scripts -->
    <!-- Scripts -->
    <!--<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>-->
    <!--<script src="../assets/js/script.js"></script>-->

    

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <script>
        // Menu Trigger
        $('#menuToggle').on('click', function(event) {
            var windowWidth = $(window).width();
            if (windowWidth < 1010) {
                $('body').removeClass('open');
                if (windowWidth < 760) {
                    $('#left-panel').slideToggle();
                } else {
                    $('#left-panel').toggleClass('open-menu');
                }
            } else {
                $('body').toggleClass('open');
                $('#left-panel').removeClass('open-menu');
            }
        });
    </script>
    <!--Local Stuff-->

</body>

</html>