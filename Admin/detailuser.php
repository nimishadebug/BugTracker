<?php
include('../dbconnection.php');
session_start();

//if (isset($_GET['Detail'])) {
$RID = $_GET['Detail'];
//}

if (isset($_SESSION['login'])) {
    //if true the user is logged in from the beginning.
    $rEmail = $_SESSION['rEmail'];
    if ($_SESSION['login'] != NULL) {
    } else {
        //redirected. if the user tries to access the userlogin.php then he will be redirected.
        echo "<script>location.href = '../UserLogin.php'</script>";
    }
}

$sql = "SELECT * FROM userregistration_db WHERE r_login_id= $RID";
//$sql = "SELECT * FROM userregistration_db WHERE r_login_id= 'r_login_id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        //$ruserid = $row['r_userid'];       
        $username = $row['r_name'];
        //$myselect = $row['r_select'];
    }
}

?>


<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Dashboard - BugTracker</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/main.css">

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
                    <li class="nav-item">
                        <a href="ManageProjectUsers.php"><i class="menu-icon fa fa-square"></i>Manage Project Users </a>
                    </li>
                    <li class="nav-item">
                        <a href="MyProject.php"><i class="menu-icon fa fa-tasks"></i>My Projects </a>
                    </li>
                    <li class="nav-item">
                        <a href="MyTicket.php"><i class="menu-icon fa fa-ticket"></i>My Tickets </a>
                    </li>
                    <li class="active bg-primary">
                        <a style="color: white;" href="UserList.php"><i style="color: white;" class="menu-icon fa fa-users"></i>User List</a>
                    </li>
                    <li class="nav-item">
                        <a href="UserList.php"><i class="menu-icon fa fa-comment"></i>Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="ChangePassword.php"><i class="menu-icon fa fa-key"></i>Change Profile Settings </a>
                    </li>
                    <li class="nav-item" style="padding-bottom:12px;">
                        <a href="AdminLogout.php"><i class="menu-icon fa fa-arrow-right"></i>Logout</a>
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
                    <a class="navbar-brand" href="../index.php">Bug Tracker</a>
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
                                    <p>Server #1 overloaded.</p>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <i class="fa fa-info"></i>
                                    <p>Server #2 overloaded.</p>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <i class="fa fa-warning"></i>
                                    <p>Server #3 overloaded.</p>
                                </a>
                            </div>
                        </div>

                        <div class="dropdown for-message">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="message" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-envelope"></i>
                                <span class="count bg-primary">4</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="message">
                                <p class="red">You have 4 Mails</p>
                                <a class="dropdown-item media" href="#">
                                    <span class="photo media-left"><img alt="avatar"></span>
                                    <div class="message media-body">
                                        <span class="name float-left">Jonathan Smith</span>
                                        <span class="time float-right">Just now</span>
                                        <p>Hello, this is an example msg</p>
                                    </div>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <span class="photo media-left"><img alt="avatar"></span>
                                    <div class="message media-body">
                                        <span class="name float-left">Jack Sanders</span>
                                        <span class="time float-right">5 minutes ago</span>
                                        <p>Lorem ipsum dolor sit amet, consectetur</p>
                                    </div>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <span class="photo media-left"><img alt="avatar"></span>
                                    <div class="message media-body">
                                        <span class="name float-left">Cheryl Wheeler</span>
                                        <span class="time float-right">10 minutes ago</span>
                                        <p>Hello, this is an example msg</p>
                                    </div>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <span class="photo media-left"><img alt="avatar"></span>
                                    <div class="message media-body">
                                        <span class="name float-left">Rachel Santos</span>
                                        <span class="time float-right">15 minutes ago</span>
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
        <div class="content" style="margin-top: 5px; background-color:white;">

            <div class="row">
                <div class="col-sm-4 text-white text-center mt-2">
                    <div class="card box p-2 text-white mb-3;">
                        <div class="card-header bg-primary">User's Name:</div>
                        <div class="card-body" style="color: black;">

                            <?php
                            $sqli = mysqli_query($conn, "SELECT r_name FROM userregistration_db WHERE r_login_id ='$RID'");
                            while ($row = mysqli_fetch_array($sqli)) {
                            ?>
                                <?php echo $row["r_name"]; ?>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>

                <div class="col-sm-4 text-white text-center mt-2">
                    <div class="card box p-2 text-white mb-3;">
                        <div class="card-header bg-primary">User's Email:</div>
                        <div class="card-body" style="color: black;">

                            <?php
                            $sqli = mysqli_query($conn, "SELECT r_email FROM userregistration_db WHERE r_login_id = '$RID'");
                            while ($row = mysqli_fetch_array($sqli)) {
                            ?>
                                <?php echo $row["r_email"]; ?>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>

                <div class="col-sm-4 text-white text-center mt-2">
                    <div class="card box p-2 text-white mb-3;">
                        <div class="card-header bg-primary">User's Role:</div>
                        <div class="card-body" style="color: black;">

                            <?php
                            $sqli = mysqli_query($conn, "SELECT r_select FROM userregistration_db WHERE r_login_id = '$RID'");
                            while ($row = mysqli_fetch_array($sqli)) {
                            ?>
                                <?php echo $row["r_select"]; ?>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12" style="margin-bottom: 50px;">
                <div class="card" style="color:#5777ba;">
                    <div class="mx-5 mt-5 text-center">
                        <div class="card-header p-4 bg-primary" style="color: white;">
                            TICKETS SUBMITTED BY THIS USER
                        </div>
                        <div class="card-body">
                            <table id="myTable" class="table display table-bordered table-hover" style="width:100%">

                                <thead>
                                    <tr>
                                        <th scope="col" style="text-align:center;">Project</th>
                                        <th scope="col" style="text-align:center;">Info</th>
                                        <th scope="col" style="text-align:center;">Topic</th>
                                        <th scope="col" style="text-align:center;">Priority</th>
                                        <th scope="col" style="text-align:center;">created</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                    $sql = "SELECT project_db.p_id, project_db.p_name, submitrequest_db.request_id, submitrequest_db.request_info,
                                                        submitrequest_db.request_topic, submitrequest_db.request_priority, submitrequest_db.request_status, submitrequest_db.request_time
                                                         FROM project_db, submitrequest_db WHERE project_db.p_id=submitrequest_db.p_id AND r_userid= '$RID'";
                                    //{$_SESSION['r_login_id']}
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {

                                            echo "<tr><td>" . $row["p_name"] .  "</td><td>" . $row["request_topic"] . "</td><td>" . $row["request_info"] . "</td><td>" . $row["request_priority"] . "</td><td>" . $row["request_time"] . "</td></tr>";
                                        }
                                        echo "</table>";
                                    } else {
                                        //echo "NO RESULT";
                                    }

                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12" style="margin-bottom: 50px;">
                <div class="card" style="color:#5777ba;">
                    <div class="mx-5 mt-5 text-center">
                        <div class="card-header p-4 bg-primary" style="color: white;">
                            COMMENTS SUBMITTED BY THIS USER
                        </div>
                        <div class="card-body">
                            <table id="myTable" class="table display table-bordered table-hover" style="width:100%">

                                <thead>
                                    <tr>
                                        <th scope="col" style="text-align:center;">Comment</th>
                                        <th scope="col" style="text-align:center;">Ticket Info</th>
                                        <th scope="col" style="text-align:center;">Time</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                    $sql = "SELECT comment_db.c_id, comment_db.comment_desc, comment_db.commented_project, comment_db.commented_by, 
                                    comment_db.comment_time, submitrequest_db.request_id, submitrequest_db.request_info, submitrequest_db.r_name FROM `comment_db`,
                                  `submitrequest_db` WHERE submitrequest_db.request_id = comment_db.commented_project AND r_userid= '$RID'";
                                    //{$_SESSION['r_login_id']}
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {

                                            echo "<tr><td>" . $row["comment_desc"] . "</td><td>" . $row["request_info"] ."</td><td>" . $row["comment_time"] . "</td></tr>";
                                        }
                                        echo "</table>";
                                    } else {
                                        //echo "NO RESULT";
                                    }

                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Content Starts-->


        <!-- /*.content*/ -->
        <!-- Footer -->
        <footer class="site-footer " style="position: fixed;bottom:0;right:0;left:0;background:#eff2f8;">
            <div class="footer-inner ">
                <div class="row mb-3" style="display:flex;">
                    <div class="col-sm-12 text-center">Copyright &copy; Bug Tracker:Designed by <a href=#>Nimisha Dubey</a></div>
                </div>
            </div>
        </footer>
        <!-- /.site-footer -->

        <!--content ends here-->

        <!-- /#right-panel -->
        <!--This code is used so that the browser does not shows" Confirm Form Resubmission. The page that you're looking for used information that you entered. Returning to that
                       page might cause any action you took to be repeated. Do you want to continue" ? -->
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>


        <!--<script src="../assets/js/main.js"></script>-->
        <!--<script src="../assets/js/dashboard.js"></script>-->
        <!--<script src="../assets/js/mainjs.js"></script>-->
        <!--<script src="../assets/js/widgets.js"></script>-->

        <!--Local Stuff-->
        <script>
            // Datatable script
            $(document).ready(function() {
             //$('#myTable.display').DataTable({
             $('table.display').DataTable({
                 "pagingType": "full_numbers"
             });
         });
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
</body>

</html>