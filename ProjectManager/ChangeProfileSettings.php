<?php
include('../dbconnection.php');
//This checks if the user is in session or not. As th user leaves that particular page, its session is over.
//This is the condition where it checks whether the user is login or not and also if the user oopns it in an incognito mode
//it  will send the user to login page. Hence its session is over.
//if the user is logged in then the condition is true, and we will get the email in the rEmail variable. If it is not 
//logged in from the beginning, then the condition will come in the else part and it will be redirected.
session_start();
var_dump($_SESSION);

if (isset($_SESSION['login'])) {
    //if true the user is logged in from the beginning.This is to check if the is in session or not.
    $rEmail = $_SESSION['rEmail'];
    $userid = $_SESSION["r_login_id"];
    if ($_SESSION['login'] != NULL) {
    } else {
        //redirected. if the user tries to access the userlogin.php then he will be redirected.
        echo "<script> location.href = '../UserLogin.php'</script>";
    }
    //This will display Name and Password from the dashboard. when he logs in.
    $sql = "SELECT r_name, r_password, r_email FROM userregistration_db WHERE r_email = '$rEmail'";
    //to display the result.
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $rName = $row['r_name'];
        $rPassword = $row['r_password'];
        $rEmail = $row['r_email'];
    }
}

//name update is form value
if (isset($_POST['nameupdate'])) {
    //$rEmail = $_SESSION['rEmail'];
    //If the rName is empty 
    if (($_POST['rName'] == "") ||
        ($_POST['rPassword'] == "")
    ) {
        $passmsg =  '<div class = "alert text-center mt-4" style = "color:#fff; background-color:#5777ba;">Fill All Fields.</div>';
    } else {
        $rName = $_POST['rName'];
        $rPassword = $_POST['rPassword'];
        $rEmail = $_POST['rEmail'];

        $sql = "UPDATE userregistration_db SET r_name = '$rName', r_password = '$rPassword' WHERE r_email = '$rEmail'";
        //$sql = "UPDATE userregistration_db SET r_name = '$rName', r_password = '$rPassword', r_email = '$rEmail' WHERE r_login_id = '$userid'";
        if ($conn->query($sql) == TRUE) {
            $passmsg = '<div class="alert text-center mt-4" style="color:#fff; background:#5777ba;">Updated Successfully</div>';
        } else {
            $passmsg = '<div class="alert text-center mt-4" style="color:#fff; background:#5777ba;>Unable to update</div>';
        }
    }
}

$sql = mysqli_query($conn, "SELECT new_r_login_p_id.p_id, new_r_login_p_id.r_pmanager, project_db.p_id, project_db.p_name FROM new_r_login_p_id, project_db WHERE new_r_login_p_id.status_pmanager = 0 AND r_pmanager = $userid  AND new_r_login_p_id.p_id = project_db.p_id ");
$unread = mysqli_num_rows($sql);

?>

<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard - BugTracker</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/main.css">


</head>

<body>
    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default" style="background-color: #f8f8f8;">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="nav-item" style="padding-top:15px;color:white;">
                        <a href="ProjectManagerDashboard.php"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                    </li>
                    <li class="nav-item">
                        <a href="ProjectUsers.php"><i class="menu-icon fa fa-square"></i>Manage Project Users </a>
                    </li>
                    <li class="nav-item">
                        <a href="ProjectManagerProjects.php"><i class="menu-icon fa fa-tasks"></i>My Projects </a>
                    </li>
                    <li class="nav-item">
                        <a href="ProjectManagerTickets.php"><i class="menu-icon fa fa-ticket"></i>My Tickets </a>
                    </li>
                    <li class="active bg-primary">
                        <a style="color: white;" href="ChangeProfileSettings.php"><i style="color: white;" class="menu-icon fa fa-key"></i>Change Profile Settings </a>
                    </li>
                    <li class="nav-item" style="padding-bottom:12px;">
                        <a href="ProjectManagerLogout.php"><i class="menu-icon fa fa-arrow-right"></i>Logout</a>
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

                        <div class="dropdown for-notification">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell"></i>
                                <div class="count bg-danger"><?php echo $unread ?></div>
                            </button>
                            <div class="dropdown-menu" id="notifications" aria-labelledby="notification">
                                <a class="dropdown-item media" href="#">
                                    <i class="fa fa-check"></i>
                                    <?php
                                    $sql = "SELECT new_r_login_p_id.p_id, new_r_login_p_id.r_pmanager, project_db.p_id, project_db.p_name FROM new_r_login_p_id, project_db WHERE new_r_login_p_id.status_pmanager = 0 AND r_pmanager = $userid  AND new_r_login_p_id.p_id = project_db.p_id ";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <p>You have been assigned a project: <?php echo $row["p_name"] ?></p>
                                            <a>
                                        <?php
                                        }
                                    } else {
                                        echo "You Have no new notifications.";
                                    }
                                        ?>
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
                            </div>
                        </div>
                    </div>

                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="../assets/img/images.png" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="ChangePassword.php"><i class="fa fa- user"></i>My Profile</a>

                            <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">13</span></a>

                            <a class="nav-link" href="ChangePassword.php"><i class="fa fa -cog"></i>Settings</a>

                            <a class="nav-link" href="UserLogout.php"><i class="fa fa-power -off"></i>Logout</a>
                        </div>
                    </div>

                </div>
            </div>
        </header>
        <!-- /#header -->
        <!-- Content Starts-->
        <div class="content">
            <!--User Dashboard Form-->


            <div class="row mx-5 twxt-white ">
                <div class="col-sm-12 mt-5 text-center">
                    <div class="card box card-box p-2 text-whte mb-3 max-width:18rem;">
                        <div class="card-header bg-primary text-white">Change Profile Settings</div>
                        <div class="card-body">

                            <form action="" method="POST" class="mx-5">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="rEmail" value="<?php echo $rEmail ?>" readonly></input>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="rName" placeholder="Change name.." value="<?php echo $rName ?>"></input>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="rPassword" placeholder="Change password.." value="<?php echo $rPassword ?>"></input>
                                </div>
                                <input type="submit" value="update" class="btn btn-primary" name="nameupdate">
                                <?php if (isset($passmsg)) {
                                    echo $passmsg;
                                } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- /*.content*/ -->
        <!-- Footer -->
        <footer class="site-footer " style="position: fixed;bottom:0;right:0;left:0;">
            <div class="footer-inner bg-white">
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
        <!--Local Stuff-->
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

            $(document).ready(function() {
                $('#notifications').click(function() {
                    jQuery.ajax({
                        url: 'update_notification_status.php',
                        success: function() {
                            $('.for-notification').fadeToggle('fast', 'linear');
                            $('.count').fadeOut('slow');
                        }
                    })
                    return false;
                });

                $(document).click(function() {
                    $('#notifications').show();
                });
            });
        </script>

        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
</body>

</html>