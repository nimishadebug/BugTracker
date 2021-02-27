<?php
include('../dbconnection.php');
session_start();
error_reporting(0);
if (isset($_SESSION['login'])) {
    //if true the user is logged in from the beginning.
    $rEmail = $_SESSION['rEmail'];
    $userid = $_SESSION['r_login_id'];
} else {
    //redirected. if the user tries to access the userlogin.php then he will be redirected.
    echo "<script>location.href = '../dashboard.php'</script>";
}

if (isset($_POST['insert'])) {
    $ruser = $_POST['projectuser'];
    $rdeveloper = $_POST['projectdeveloper'];
    $rpmanager = $_POST['projectmanager'];
    $rprojectroles = $_POST['projectroles'];

    $sql = "INSERT INTO manageusers(r_user,r_developer,r_pmanager,r_login_id)VALUES('$ruser','$rdeveloper','$rpmanager','$rprojectroles')";
    $result = $conn->query($sql) or die(mysqli_error($conn));
    if ($result) {
        $msg = '<div class = "alert mt-4 btn-block" style = "color:#fff; background-color:#5777ba;">Submitted Successfully</div>'; //.$conn->insert_id;
    } else {
        $msg = '<div class = "alert mt-4 btn-block" style = "color:#fff; background-color:#5777ba;">Unable To Submit.</div>'; //(mysqli_connect_error());
    }
}

$sql = mysqli_query($conn, "SELECT submitrequest_db.p_id, project_db.p_id, project_db.p_name FROM submitrequest_db, project_db WHERE submitrequest_db.admin_ticket_status = 0 AND submitrequest_db.p_id = project_db.p_id ");
$unread = mysqli_num_rows($sql);
?>

<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Profile - BugTracker</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Css Links-->

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
                    <li class="nav-item" style="padding-top:15px;">
                        <a href="AdminDashboard.php"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                    </li>
                    <li class="active bg-primary">
                        <a style="color: white;" href="ManageRoleAssign.php"><i style="color: white;" class="menu-icon fa fa-user-plus"></i>Manage Role Assignment </a>
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
                    <li class="nav-item">
                        <a href="UserList.php"><i class="menu-icon fa fa-users"></i>User List</a>
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
                    <a class="navbar-brand" href="index.php">Bug Tracker</a>
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
                                <span class="count bg-danger"><?php echo $unread ?></span>
                            </button>
                            <div class="dropdown-menu" id="notifications" aria-labelledby="notification" style="padding: 13px;;">
                                <?php
                                $sql = "SELECT submitrequest_db.p_id, project_db.p_id, project_db.p_name FROM submitrequest_db, project_db WHERE submitrequest_db.admin_ticket_status = 0 AND submitrequest_db.p_id = project_db.p_id ";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <i class="fa fa-check"></i>
                                        <p>New Ticket has been added in this project: <?php echo $row["p_name"] ?></p>
                                        <a class="dropdown-item media" href="#">
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
        <div class="content">
            <div class="card" style="color:#5777ba;">
                <div class="card-header bg-primary text-center" style="color:white;">MANAGE USER ROLES</div>

                <div class="row mx-5 text-center">
                    <div class="col-sm-4 text-white text-center mt-5">
                        <div class="card box p-2 text-white mb-3">
                            <div class="card-header bg-primary text-white">Developer(s)</div>
                            <div class="card-body">
                                <form id="form" method="POST">
                                    <div class="form-group" style="color:#5777ba;">
                                        <label for="projectdeveloper" style="color:#5777ba;">Choose any one:</label>

                                        <select class="form-control chosen-select" multiple="multiple" data-style="btn-primary" aria-describedby="projectdeveloper" name="projectdeveloper">

                                            <?php
                                            $sqli = mysqli_query($conn, "SELECT r_login_id, r_name FROM userregistration_db WHERE r_select = 'developer'");
                                            while ($row = mysqli_fetch_array($sqli)) {
                                                echo "<option value=" . $row['r_login_id'] . ">" . $row['r_name'] . "</option>";
                                            }
                                            ?>

                                        </select>
                                        <!--<input type="hidden" id="projectss" value="<?php echo $c_fetch['p_id'] ?>">-->

                                    </div>

                                    <!--</form>-->
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 text-white text-center mt-5">
                        <div class="card box p-2 text-white mb-3">
                            <div class="card-header bg-primary text-white">Manager(s)</div>
                            <div class="card-body">
                                <!--<form id="form" method="POST">-->
                                <div class="form-group" style="color:#5777ba;">
                                    <label for="projectmanager" style="color:#5777ba;">Choose any one:</label>

                                    <select class="form-control chosen-select" multiple="multiple" data-style="btn-primary" aria-describedby="projectmanager" name="projectmanager">

                                        <?php
                                        $sqli = mysqli_query($conn, "SELECT r_login_id, r_name FROM userregistration_db WHERE r_select = 'project manager'");
                                        //$sqli = mysqli_query($conn, "SELECT r_login_id, r_name FROM userregistration_db WHERE r_select != 'admin'");
                                        while ($row = mysqli_fetch_array($sqli)) {
                                            echo "<option value=" . $row['r_login_id'] . ">" . $row['r_name'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                    <!--<input type="hidden" id="projects" value="<?php echo $c_fetch['p_id'] ?>">-->

                                </div>

                                <!--</form>-->
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 text-white text-center mt-5">
                        <div class="card box p-2 text-white mb-3">
                            <div class="card-header bg-primary text-white">User(s)</div>
                            <div class="card-body">
                                <!--<form id="form" method="POST">-->
                                <div class="form-group" style="color:#5777ba;">
                                    <label for="projectuser" style="color:#5777ba;">Choose any one:</label>

                                    <select class="form-control chosen-select" multiple="multiple" data-style="btn-primary" aria-describedby="projectuser" name="projectuser">

                                        <?php
                                        $sqli = mysqli_query($conn, "SELECT r_login_id, r_name FROM userregistration_db WHERE r_select = 'user'");
                                        //$sqli = mysqli_query($conn, "SELECT r_login_id, r_name FROM userregistration_db WHERE r_select != 'admin'");
                                        while ($row = mysqli_fetch_array($sqli)) {
                                            echo "<option value=" . $row['r_login_id'] . ">" . $row['r_name'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                    <!--<input type="hidden" id="project" value="<?php echo $c_fetch['p_id'] ?>">-->

                                </div>

                                <!--</form>-->
                            </div>
                        </div>
                    </div>



                    <div class="col-sm-6 text-white text-center mt-5" style="display: block;margin-left: auto;margin-right: auto;">
                        <div class="card box p-2 text-white mb-3">
                            <div class="card-header bg-primary text-white">Role(s)</div>
                            <div class="card-body">
                                <!--<form id="form" method="POST">-->
                                <div class="form-group" style="color:#5777ba;">
                                    <label for="projectroles" style="color:#5777ba;">Choose any one:</label>
                                    <select class="form-control" multiple="multiple" data-style="btn-primary" name="projectroles">
                                        <option value="1">User</option>
                                        <option value="2">Developer</option>
                                        <option value="3">Project Manager</option>
                                    </select>
                                </div>

                                <!--</form>-->
                            </div>
                        </div>
                    </div>




                    <div class="col-sm-12 mb-5">
                        <input name="insert" class="btn btn-primary btn-large btn-block" type="submit" value="Add User Role">
                        <!--name="insert" id="save_group"-->
                        <!--<button type="button" name="insert"  class="btn btn-primary btn-large btn-block">Add User(s)</button>-->
                    </div>
                    </form>
                    <?php
                    if (isset($msg)) {
                        echo $msg;
                    }
                    ?>
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
</body>

</html>