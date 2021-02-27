<?php
include('../dbconnection.php');
session_start();

if (isset($_GET['GetTopic'])) {
    $PID = $_GET['GetTopic'];
}

if (isset($_SESSION['login'])) {
    //if true the user is logged in from the beginning.
    $rEmail = $_SESSION['rEmail'];
    $userid = $_SESSION['r_login_id'];
    if ($_SESSION['login'] != NULL) {
    } else {
        //redirected. if the user tries to access the userlogin.php then he will be redirected.
        echo "<script>location.href = '../UserLogin.php'</script>";
    }
}

$sql = "SELECT * FROM userregistration_db WHERE r_login_id= {$_SESSION['r_login_id']}";
//$sql = "SELECT * FROM userregistration_db WHERE r_login_id= 'r_login_id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userid = $row['r_login_id'];       
        $username = $row['r_name'];
        //$myselect = $row['r_select'];
    }
}

if (isset($_POST['isnert'])) {
    $myFile = $_FILES['myFile'];
    $fileName = $_FILES['myFile']['name'];
    $fileTmpName = $_FILES['myFile']['tmp_name'];
    $fileSize = $_FILES['myFile']['size'];
    $fileError = $_FILES['myFile']['error'];
    $fileType = $_FILES['myFile']['type'];



    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 500000) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = 'uploads/' . $fileNameNew;
                //echo realpath($fileTmpName);
                move_uploaded_file($fileTmpName, $fileDestination);
            } else {
                echo "your file is too big!";
            }
        } else {
            echo "you had a problem while uploading your file!";
        }
    } else {
        echo "you canot upload files of this type!";
    }
}

if (isset($_POST['insert'])) {
    $commentdesc = $_POST['comment'];
    //$username = $_SESSION["r_login_id"];

    $sql = "INSERT INTO `comment_db`(commented_project, comment_desc, commented_by, commentedby_id)VALUES('$PID', '$commentdesc', '$username', '$userid')";
    //$sql = "INSERT into comment_db(comment_desc, commented_project, commented_by, comment_time)VALUES($commentdesc, $commentproject, $commentedby, $commented_time)";

    $result = $conn->query($sql) or die(mysqli_error($conn));
    if ($result) {
        $msg = '<div class = "alert mt-4" style = "color:#fff; background-color:#5777ba;">Comment Submitted Successfuly.</div>'; //.$conn->insert_id;
    } else {
        $msg = '<div class = "alert mt-4" style = "color:#fff; background-color:#5777ba;">Unable To Submit Your Request.</div>'; //(mysqli_connect_error());
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
        <div class="content" style="margin-top: 5px; background-color:white;">

            <div class="row">
                <div class="col-sm-4 text-white text-center mt-2">
                    <div class="card box p-2 text-white mb-3;">
                        <div class="card-header bg-primary">Request Info:</div>
                        <div class="card-body" style="color: black;">

                            <?php
                            $sqli = mysqli_query($conn, "SELECT request_info FROM submitrequest_db WHERE request_id ='$PID'");
                            while ($row = mysqli_fetch_array($sqli)) {
                            ?>
                                <?php echo $row["request_info"]; ?>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>

                <div class="col-sm-4 text-white text-center mt-2">
                    <div class="card box p-2 text-white mb-3;">
                        <div class="card-header bg-primary">Request Description:</div>
                        <div class="card-body" style="color: black;">

                            <?php
                            $sqli = mysqli_query($conn, "SELECT request_desc FROM submitrequest_db WHERE request_id = '$PID'");
                            while ($row = mysqli_fetch_array($sqli)) {
                            ?>
                                <?php echo $row["request_desc"]; ?>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>

                <div class="col-sm-4 text-white text-center mt-2">
                    <div class="card box p-2 text-white mb-3;">
                        <div class="card-header bg-primary">Request Topic:</div>
                        <div class="card-body" style="color: black;">

                            <?php
                            $sqli = mysqli_query($conn, "SELECT request_topic FROM submitrequest_db WHERE request_id = '$PID'");
                            while ($row = mysqli_fetch_array($sqli)) {
                            ?>
                                <?php echo $row["request_topic"]; ?>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 text-white text-center mt-2">
                    <div class="card box p-2 text-white mb-3;">
                        <div class="card-header bg-primary">Request Priority:</div>
                        <div class="card-body" style="color: black;">

                            <?php
                            $sqli = mysqli_query($conn, "SELECT request_priority FROM submitrequest_db WHERE request_id ='$PID'");
                            while ($row = mysqli_fetch_array($sqli)) {
                            ?>
                                <?php echo $row["request_priority"]; ?>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>

                <div class="col-sm-4 text-white text-center mt-2">
                    <div class="card box p-2 text-white mb-3;">
                        <div class="card-header bg-primary">Request Status:</div>
                        <div class="card-body" style="color: black;">

                            <?php
                            $sqli = mysqli_query($conn, "SELECT request_status FROM submitrequest_db WHERE request_id = '$PID'");
                            while ($row = mysqli_fetch_array($sqli)) {
                            ?>
                                <?php echo $row["request_status"]; ?>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>

                <div class="col-sm-4 text-white text-center mt-2">
                    <div class="card box p-2 text-white mb-3;">
                        <div class="card-header bg-primary">Request Created:</div>
                        <div class="card-body" style="color: black;">

                            <?php
                            $sqli = mysqli_query($conn, "SELECT request_time FROM submitrequest_db WHERE request_id = '$PID'");
                            while ($row = mysqli_fetch_array($sqli)) {
                            ?>
                                <?php echo $row["request_time"]; ?>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6 text-white text-center mt-2">
                    <div class="card box p-2 text-white mb-8;">
                        <div class="card-header bg-primary">Comments :</div>
                        <div class="card-body" style="color: black;">
                            <div class="col">
                                <form action="" method="POST">
                                    <textarea type="text" class="form-control" placeholder="write a comment.." rows="5" id="comment" name="comment"></textarea>
                                    <button class="btn btn-primary mt-2 btn-block" name="insert" id="submit">Submit</button>
                                </form>

                                <?php if (isset($msg)) {
                                    echo $msg;
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 text-white text-center mt-2">
                    <div class="card box p-2 text-white mb-3">
                        <div class="card-header bg-primary">Attachments :</div>
                        <div class="card-body" style="color: black;">

                            <form action="#" method="POST" enctype="multipart/form-data">
                                <input type="file" id="myFile" name="myFile">
                                <button class="btn btn-primary mt-2" name="isnert">Upload</button>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6 text-white text-center mt-2" >
                    <div class="card box p-2 text-white mb-3">
                        <div class="card-header bg-primary">All Comments :</div>
                        <div class="card-body" style="color: black;">

                            <table class="table display table-bordered mt-5" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Comment</th>
                                        <th scope="col">Commented by</th>
                                        <th scope="col">Time</th>
                                        
                                    </tr>
                                </thead>
                                <tbody style="text-align:center;background-color:white;">

                                    <?php
                                    //request_id is removed.
                                    $sql = "SELECT c_id, comment_desc, commented_by, commented_project, comment_time FROM comment_db WHERE commented_project = '$PID'";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $CID = $row['c_id'];
                                            $COD = $row['comment_desc'];
                                            $CTB = $row['commented_by'];
                                            $CCT = $row['comment_time'];
                                    ?>
                                            <tr>
                                                <td><?php echo $COD ?></td>
                                                <td><?php echo $CTB ?></td>
                                                <td><?php echo $CCT ?></td>
                                   
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

             <div class="col-sm-6 text-white text-center mt-2"> 
                <div class="card box p-2 text-white mb-3" style="margin: 6px;">
                    <div class="card-header bg-primary text-center">My Comments :</div>
                    <div class="card-body" style="color: black;">

                        <table class="table display table-bordered mt-5" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Comment</th>
                                    <th scope="col">Commented by</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody style="text-align:center;background-color:white;">

                                <?php

                                $sql = "SELECT c_id, comment_desc, commented_by, commented_project, comment_time FROM comment_db WHERE commented_project = '$PID' AND commentedby_id = $userid";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $CID = $row['c_id'];
                                        $COD = $row['comment_desc'];
                                        $CTB = $row['commented_by'];
                                        $CCT = $row['comment_time'];
                                ?>
                                        <tr>
                                            <td><?php echo $COD ?></td>
                                            <td><?php echo $CTB ?></td>
                                            <td><?php echo $CCT ?></td>
                                            <td><a href="editcomment.php?GetID=<?php echo $PID ?>" class="btn btn-warning">Edit</a></td>
                                            <td><a href="deletecomment.php?Del=<?php echo $PID ?>" class="btn btn-danger">Delete</a></td>
                                        </tr>
                                <?php
                                    }
                                    echo "</table>";
                                } else {
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
             </div>  

              <div class="col-sm-12 text-white text-center mt-2" style="margin-bottom: 80px;">  
                <div class="card box p-2 text-white mb-3">
                    <div class="card-header bg-primary text-center">Ticket history:</div>
                    <div class="card-body" style="color: black;">
                    <table class="table display table-bordered mt-5" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Ticket Topic</th>
                                    <th scope="col">Ticket Priority</th>
                                    <th scope="col">Ticket Status</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody style="text-align:center;background-color:white;">

                                <?php

                                $sql = "SELECT request_id, request_topic, request_status, request_priority, r_userid, request_time FROM submitrequest_db order by request_topic desc limit 3";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $RID = $row['request_id'];
                                        $RTO = $row['request_topic'];
                                        $RTS = $row['request_status'];
                                        $RTP = $row['request_priority'];
                                        $RTU = $row['request_time'];
                                        
                                ?>
                                        <tr>
                                            <td><?php echo $RTO?></td>
                                            <td><?php echo $RTS ?></td>
                                            <td><?php echo $RTP ?></td>
                                            <td><?php echo $RTU ?></td>
                                            <td><a href="editticketdetail.php?GetID=<?php echo $TID ?>" class="btn btn-warning">Edit</a> </td>
                                            <td><a href="deleteticketdetail.php?Del=<?php echo $TID ?>" class="btn btn-danger">Delete</a></td>
                                        </tr>
                                <?php
                                    }
                                    echo "</table>";
                                } else {
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
      $(document).ready(function() {
             $('table.display').DataTable({
                 "pagingType": "full_numbers"
             });
         });
    </script>
</body>

</html>