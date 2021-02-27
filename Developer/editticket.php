<?php

// TO SET UP CONNECTION WITH dbconnection.php
include('../dbconnection.php');
//To start or resume existing session.
session_start();
var_dump($_SESSION['login']);
$userid = $_SESSION["r_login_id"]; 

if (isset($_GET['GetID'])) {
$TID = $_GET['GetID'];
}

if (isset($_POST['update'])) {
    //checking for empty fields.
    if (($_POST['requestinfo'] == "") ||
        ($_POST['requestdesc'] == "") ||
        ($_POST['requesttopic'] == "") ||
        ($_POST['requestpriority'] == "") ||
        ($_POST['requeststatus'] == "")
    ) {
        $msg = '<div class = "alert mt-4" style = "color:#fff; background-color:#5777ba;">Fill all Fields.</div>'; 
    } else {
        
        $requestinfo = $_POST['requestinfo'];
        $requestdesc = $_POST['requestdesc'];
        $requesttopic = $_POST['requesttopic'];
        $requestpriority = $_POST['requestpriority'];
        $requeststatus = $_POST['requeststatus'];

        $sql =  "UPDATE submitrequest_db SET request_info = '$requestinfo', request_desc = '$requestdesc', request_topic = '$requesttopic',
        request_priority = '$requestpriority', request_status = '$requeststatus' WHERE request_id='$TID'";

        if ($conn->query($sql) == TRUE) {
            $msg = '<div class="alert mt-4" style = "color:#fff; background-color:#5777ba";>Updated Successfully.</div>';
        } 
        //else {
            //$msg = '<div class="alert mt-4" style = "color:#fff; background-color:#5777ba";>Unable to update.</div>';
        //}
    }
}

$sql = mysqli_query($conn, "SELECT new_r_login_p_id.p_id, new_r_login_p_id.r_developer, project_db.p_id, project_db.p_name FROM new_r_login_p_id, project_db WHERE new_r_login_p_id.status_developer = 0 AND r_developer = $userid  AND new_r_login_p_id.p_id = project_db.p_id ");
$unread = mysqli_num_rows($sql);
?>


<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Developer Dashboard - BugTracker</title>
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
                        <a href="DeveloperDashboard.php"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                    </li>
                    <li class="nav-item">
                        <a href="Developerproject.php"><i class="menu-icon fa fa-tasks"></i>Projects </a>
                    </li>
                    <li class="active bg-primary">
                        <a style="color: white;" href="Developerticket.php"><i style="color: white;" class="menu-icon fa fa-ticket"></i>My Tickets </a>
                    </li>
                    <li class="nav-item">
                        <a href="ChangeProfileSetting.php"><i class="menu-icon fa fa-key"></i>Change Profile Settings </a>
                    </li>
                    <li class="nav-item" style="padding-bottom:12px;">
                        <a href="DeveloperLogout.php"><i class="menu-icon fa fa-arrow-right"></i>Logout</a>
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
                                <div class="count bg-danger"><?php echo $unread ?></div>
                            </button>
                            <div class="dropdown-menu" id="notifications" aria-labelledby="notification">
                                <a class="dropdown-item media" href="#">
                                    <i class="fa fa-check"></i>
                                    <?php
                                    $sql = "SELECT new_r_login_p_id.p_id, new_r_login_p_id.r_developer, project_db.p_id, project_db.p_name FROM new_r_login_p_id, project_db WHERE new_r_login_p_id.status_developer = 0 AND r_developer = $userid  AND new_r_login_p_id.p_id = project_db.p_id ";
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

        <div class="content" style="margin-bottom:55px;">
            <div class="row mx-5 text-white mt-5">
                <div class="col-sm-12">
                    <div class="card box p-2 text-white mb-3">
                        <div class="card-header bg-primary">Edit Ticket</div>
                        <div class="card-body">


                            <!--Submit Request Form Starts-->
                            <?php
                            $query = "SELECT request_info, request_desc, request_topic, request_priority, request_status FROM submitrequest_db WHERE request_id = '$TID'";
                            $result = $conn->query($query);
                            if ($result->num_rows == 1) {
                                $row = $result->fetch_assoc();
                                $requestinfo = $row['request_info'];
                                $requestdesc = $row['request_desc'];
                                $requesttopic = $row['request_topic'];
                                $requeststatus = $row['request_status'];
                                $requestpriority = $row['request_priority'];
                            }
                            ?>

                            <div class="col-sm-6 col-md-6 mt-5 my-5" style="padding-bottom: 49px;">
                                <form action="" id="form" method="POST">

                                    <div class="form-group" style="color:#5777ba;">
                                        <label for="requestinfo">Ticket Info</label>
                                        <input type="text" class="form-control" id="requestinfo" value="<?php echo $requestinfo ?>" name="requestinfo">
                                    </div>

                                    <div class="form-group" style="color:#5777ba;">
                                        <label for="requestdesc">Ticket Description</label>
                                        <input type="text" class="form-control" id="requestdesc" value="<?php echo $requestdesc ?>" name="requestdesc">
                                    </div>

                                    <div class="form-group" style="color:#5777ba;">
                                        <label for="requesttopic">Ticket Topic</label>
                                        <input type="text" class="form-control" id="requesttopic" value="<?php echo $requesttopic ?>" name="requesttopic">
                                    </div>

                                    <div class="form-group" style="color:#5777ba;">
                                        <label for="requeststatus">Ticket Status</label>
                                        <select class="form-control" data-style="btn-primary" id="requeststatus" value="<?php echo $requeststatus ?>" name="requeststatus">
                                            <option>Select any one..</option>
                                            <option value="new">New</option>
                                            <option value="inprogress">In Progress</option>
                                            <option value="delayed">Delayed</option>
                                            <option value="unreleased">Unreleased</option>
                                            <option value="released">Released</option>
                                            <option value="completed">Completed</option>
                                            <option value="underreview">UnderReview</option>
                                            <option value="finalreview">FinalReview</option>
                                            <option value="denied">Denied</option>
                                            <option value="approved">Approved</option>
                                        </select>
                                    </div>

                                    <!--Select From option-->
                                    <div class="form-group" style="color:#5777ba;">
                                        <label for="requestpriority">Ticket Priority</label>
                                        <select class="form-control" data-style="btn-primary" id="requestpriority" value="<?php echo $requestpriority ?>" name="requestpriority">
                                            <option>Select any one..</option>
                                            <option value="low">Low</option>
                                            <option value="normal">Normal</option>
                                            <option value="high">High</option>
                                            <option value="emergency">Emergency</option>
                                        </select>
                                    </div>

                                    <div>
                                        <button class="btn btn-primary" name="update">Update</button>
                                        <a href="MyTicket.php" class="btn btn-warning">Back To Ticket</a>
                                    </div>
                                </form>

                                <?php if (isset($msg)) {
                                    echo $msg;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- /*.content*/ -->
        <!-- Footer -->
        <footer class="site-footer " style="position: fixed;bottom:0;right:0;left:0;background:#eff2f8;">
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