<?php
include('../dbconnection.php');
session_start();
var_dump($_GET['GetPro']);
var_dump($_SESSION['login']);
error_reporting(0);

if (isset($_SESSION['login'])) {
    //if true the user is logged in from the beginning.
    $rEmail = $_SESSION['rEmail'];
    $userid = $_SESSION['r_login_id'];
    echo $_SESSION['login'];
} else {
    //redirected. if the user tries to access the userlogin.php then he will be redirected.
    echo "<script>location.href = '../dashboard.php'</script>";
}

if (isset($_GET['GetPro'])) {
    $TID = $_GET['GetPro'];
}

$sql = mysqli_query($conn, "SELECT new_r_login_p_id.p_id, new_r_login_p_id.r_developer, project_db.p_id, project_db.p_name FROM new_r_login_p_id, project_db WHERE new_r_login_p_id.status_developer = 0 AND r_developer = $userid  AND new_r_login_p_id.p_id = project_db.p_id ");
$unread = mysqli_num_rows($sql);

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
                         <a style="color: white" href="Developerticket.php"><i style="color: white;" class="menu-icon fa fa-ticket"></i>My Tickets </a>
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

        <?php
        $c_query = $conn->query("SELECT * FROM `project_db` WHERE `p_id` = '" . $TID . "'");
        $c_fetch = $c_query->fetch_array();
        $project = $c_fetch['p_id'];
        ?>

        <div class="content" style="background-color:white;">
            <div class="row mx-5 text-center">

                <div class="col-sm-12 text-white text-center mt-5">
                    <div class="card p-2 text-white mb-3;">
                        <div class="card-header bg-primary">Details</div>
                        <div class="card-body">

                            <?php
                            $sqli = "SELECT p_desc FROM `project_db` WHERE `p_id` ='$TID'";
                            $result = $conn->query($sqli);
                            while ($row = $result->fetch_array()) {
                            ?>
                                <div class="card-body text-left" style="color:black;"><?php echo $row['p_desc']; ?></div>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>

            <!--Table Starts-->
            <div class="row" style="margin-bottom:0px;">
                <div class="col-lg-12">
                    <div class="card" style="color:#5777ba;">
                        <div class="mx-5 mt-5 text-center">
                            <div class="card-header p-4 bg-primary text-white">
                                ALL TICKETS IN THIS PROJECT
                            </div>
                            <div class="card-body">
                                <table class="table display table-bordered table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align:center;">Info</th>
                                            <th scope="col" style="text-align:center;">Topic</th>
                                            <th scope="col" style="text-align:center;">Priority</th>
                                            <th scope="col" style="text-align:center;">Created</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        //$sql = "SELECT r_login_id, r_name, r_email, r_select FROM  userregistration_db";
                                        $sql = "SELECT project_db.p_id, project_db.p_name, submitrequest_db.request_id,
                                                 submitrequest_db.request_info, submitrequest_db.request_topic, submitrequest_db.request_priority,
                                                  submitrequest_db.request_status, submitrequest_db.request_time FROM project_db, submitrequest_db
                                                  WHERE project_db.p_id=submitrequest_db.p_id   
                                                  AND submitrequest_db.p_id={$_GET['GetPro']}";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $PID = $row['p_id'];
                                                $RIDI = $row['request_id'];
                                                $RTT = $row['request_info'];
                                                $RII = $row['request_topic'];
                                                $RIP = $row['request_priority'];
                                                $RTI = $row['request_time'];
                                                //echo "<tr><td>" . $row["request_topic"] . "</td><td>" . $row["request_info"] . "</td><td>" . $row["request_priority"] . "</td><td>" . $row["request_time"] . "</td></tr>";
                                        ?>        
                                                   <tr>
                                                        <td><?php echo $RTT ?></td>
                                                        <td><?php echo $RII ?></td>
                                                        <td><?php echo $RIP ?></td>
                                                        <td><?php echo $RTI ?></td>
                                                    </tr>
                                            <?php
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

            <div class="row" style="margin-bottom:50px;">
                <div class="col-lg-12">
                    <div class="card" style="color:#5777ba;">
                        <div class="mx-5 mt-5 text-center">
                            <div class="card-header p-4 bg-primary text-white">
                                MY TICKETS
                            </div>
                            <div class="card-body">
                                <table class="table display table-bordered table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align:center;">Info</th>
                                            <th scope="col" style="text-align:center;">Topic</th>
                                            <th scope="col" style="text-align:center;">Priority</th>
                                            <th scope="col" style="text-align:center;">created</th>
                                            <th scope="col" style="text-align: center;">Edit</th>
                                            <th scope="col" style="text-align: center;">Detail</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        //$sql = "SELECT r_login_id, r_name, r_email, r_select FROM  userregistration_db";
                                        $sql = "SELECT project_db.p_id, project_db.p_name, submitrequest_db.request_id,
                                                 submitrequest_db.request_info, submitrequest_db.request_topic, submitrequest_db.request_priority,
                                                  submitrequest_db.request_status, submitrequest_db.request_time FROM project_db, submitrequest_db
                                                  WHERE project_db.p_id=submitrequest_db.p_id 
                                                  AND submitrequest_db.r_userid= $_SESSION[r_login_id]
                                                  AND submitrequest_db.p_id={$_GET['GetPro']}";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                //echo "<tr><td>" . $row["request_topic"] . "</td><td>" . $row["request_info"] . "</td><td>" . $row["request_priority"] . "</td><td>" . $row["request_time"] . "</td></tr>";
                                                $PID = $row['p_id'];
                                                $RIDI = $row['request_id'];
                                                $RTT = $row['request_info'];
                                                $RII = $row['request_topic'];
                                                $RIP = $row['request_priority'];
                                                $RTI = $row['request_time'];
                                                //echo "<tr><td>" . $row["request_topic"] . "</td><td>" . $row["request_info"] . "</td><td>" . $row["request_priority"] . "</td><td>" . $row["request_time"] . "</td></tr>";
                                        ?>        
                                                   <tr>
                                                        <td><?php echo $RTT ?></td>
                                                        <td><?php echo $RII ?></td>
                                                        <td><?php echo $RIP ?></td>
                                                        <td><?php echo $RTI ?></td>
                                                        <td><a href="ticketdetailprojecteditticket.php?GetID=<?php echo $RIDI ?>" class="btn btn-warning">Edit</a> </td>
                                                        <td><a href="ticketdetail.php?TDetail=<?php echo $TID ?>" class="btn btn-success">Details</a></td>

                                                    </tr>
                                            <?php
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
        </div>
        <!--</div>-->

        <!-- Footer -->
        <footer class="site-footer " style="position: fixed;bottom:0;right:0;left:0;background:#eff2f8;">
            <div class="footer-inner ">
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


        <script>
            $(document).ready(function() {
                $('#project').blur(function() {

                    var username = $(this).val();

                    $.ajax({
                        url: 'check.php',
                        method: "POST",
                        data: {
                            r_login: r_login
                        },
                        success: function(data) {
                            if (data != '0') {
                                $('#availability').html('<span class="text-danger">Username not available</span>');
                                $('#register').attr("disabled", true);
                            } else {
                                $('#availability').html('<span class="text-success">Username Available</span>');
                                $('#register').attr("disabled", false);
                            }
                        }
                    })

                });
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