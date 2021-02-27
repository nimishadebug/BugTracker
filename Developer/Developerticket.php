<?php
// TO SET UP CONNECTION WITH dbconnection.php
include('../dbconnection.php');
//To start or resume existing session.
session_start();
var_dump($_SESSION);
//var_dump($myName);

if (isset($_SESSION['login'])) {
    echo $_SESSION['login'];
    $userid = $_SESSION["r_login_id"];
    $rEmail = $_SESSION['rEmail'];
    if ($_SESSION['login'] != NULL) {
    } else {
        echo "<script>location.href= '../UserLogin.php'</script>";
    }
}

if (isset($_REQUEST['insert'])) {
    //checking for empty fields.
    if (($_POST['requestprojects'] == "")||
        ($_POST['requestinfo'] == "") ||
        ($_POST['requestdesc'] == "") ||
        ($_POST['requesttopic'] == "") ||
        ($_POST['requestpriority'] == "") ||
        ($_POST['requeststatus'] == ""))
         {
        $msg = '<div class = "alert mt-4" style = "color:#fff; background-color:#5777ba;">Fill all Fields.</div>'; //(mysqli_connect_error());
    } else {
        $rproject = $_POST['requestprojects'];  
        $rinfo = $_POST['requestinfo'];
        $rdesc = $_POST['requestdesc'];
        $rtopic = $_POST['requesttopic'];
        $rpriority = $_POST['requestpriority'];
        $rstatus = $_POST['requeststatus'];
        $ruserid = $_SESSION["r_login_id"];
    }

    //$sql = "SELECT * FROM userregistration_db WHERE r_login_id = '".$userid."'";
    $sql = "SELECT * FROM userregistration_db WHERE r_login_id= {$_SESSION['r_login_id']}";
    //$sql = "SELECT * FROM userregistration_db WHERE r_login_id= 'r_login_id'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){   
    //$ruserid = $row['r_userid'];       
    $myName = $row['r_name'];	
    $myselect = $row['r_select'];
        }
    }
     
        $sql = "INSERT INTO submitrequest_db(request_info, request_desc, request_topic, request_priority, request_status, r_userid, r_name, r_select, p_id)VALUES('$rinfo', '$rdesc','$rtopic', '$rpriority', '$rstatus',  '$ruserid' , '$myName', '$myselect', '$rproject')";
        $result = $conn->query($sql) or die(mysqli_error($conn));
        if($result) {
        $msg = '<div class = "alert mt-4" style = "color:#fff; background-color:#5777ba;">Request Submitted Successfully,Your Requested ID is:</div>'; //.$conn->insert_id;
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
    <title>Developer Profile - BugTracker</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <!--<link rel="stylesheet" href="../assets/css/bootstrap.min.css">-->



</head>

<body>
    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default" style="background-color:#f8f8f8;">
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
                    <a class="navbar-brand" style="font-size: 18px; color:#337ab7;" href="index.php">Bug Tracker</a>
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
        <div class="content">
            <div class="d-flex justify-content-end ">
                <button type="button" style="margin-bottom:15px; border-radius:16px;" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">+ ADD NEW TICKET</button>
            </div>

         <!-- Modal -->
            <!-- Modal content-->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create New Ticket</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <div class="col-sm-6 col-md-6 mt-5 my-5" style="padding-bottom: 49px;">
                     <form action="" id="form" method="POST">
                    <div class="form-group" style="color:#5777ba;">
                        <label for="inputProjectInfo">Project</label>
                        <select class="form-control" data-style="btn-primary" id="inputProjectInfo" name="requestprojects">
                        <option value = "option">Select a Project</option>

                            <?php
                            $sqli = mysqli_query($conn,"SELECT * FROM project_db");
                            //$sql = "SELECT * FROM project_db";
                            while ($row = mysqli_fetch_array($sqli)) {
                                echo "<option value=" .$row['p_id']. ">" .$row['p_name']. "</option>";
                            }
                            ?>

                        </select>
                    </div>

                    <div class="form-group" style="color:#5777ba;">
                        <label for="inputRequestInfo">Ticket Info</label>
                        <input type="text" class="form-control" id="inputRequestInfo" placeholder="Ticket Info.." name="requestinfo">
                    </div>

                    <div class="form-group" style="color:#5777ba;">
                        <label for="inputRequestDescription">Ticket Description</label>
                        <input type="text" class="form-control" id="inputRequestDescription" placeholder="Ticket Description.." name="requestdesc">
                    </div>

                    <div class="form-group" style="color:#5777ba;">
                        <label for="inputRequestTopic">Ticket Topic</label>
                        <input type="text" class="form-control" id="inputRequestTopic" placeholder="Ticket Topic.." name="requesttopic">
                    </div>

                    <div class="form-group" style="color:#5777ba;">
                        <label for="inputRequestStatus">Ticket Status</label>
                        <select class="form-control" data-style="btn-primary" id="inputRequestStatus" name="requeststatus">
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
                        <label for="inputRequestPriority">Ticket Priority</label>
                        <select class="form-control" data-style="btn-primary" name="requestpriority">
                            <option>Select any one..</option>
                            <option value="low">Low</option>
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                            <option value="emergency">Emergency</option>
                        </select>
                    </div>

                    <!--Submit Button-->
                    <div>
                        <input type="submit" name="insert" id="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>

                <?php if (isset($msg)) {
                    echo $msg;
                } 
                ?>
            </div>

                            <div id="loading">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--Modal Ends-->

    
            <div class="data-row" style="margin-top: 20px">
                <div class="row" style="margin-bottom:50px;">
                    <div class="col-lg-12">
                        <div class="card" style="color:#5777ba;">
                            <div class="mx-5 mt-5 text-center">
                                <div class="card-header p-4 bg-primary" style="color: white;">MY TICKETS</div>
                                <div class="card-body">
                                    <table class="table table-bordered mt-5" id="myTable" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Project</th>
                                                <!--<th scope="col">Info</th>-->
                                                <!--<th scope="col">Description</th>-->
                                                <th scope="col">Topic</th>
                                                <th scope="col">Priority</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Created</th>
                                                <!--<th scope="col">Deadline</th>-->
                                                <!--<th scope="col">Created</th>-->
                                                <th scope="col">Edit</th>
                                                <!--<th scope="col">Delete</th>-->
                                                <th scope="col">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align:center;background-color:white;">

                                            <?php
                                            //request_id is removed.
                                            //$sql = "SELECT request_id, request_info, request_topic, request_priority, request_status, request_time  FROM  submitrequest_db";
                                            $sql = "SELECT project_db.p_id, project_db.p_name, submitrequest_db.request_id, submitrequest_db.request_info, submitrequest_db.request_topic, submitrequest_db.request_priority, submitrequest_db.request_status, submitrequest_db.request_time FROM project_db, submitrequest_db WHERE project_db.p_id=submitrequest_db.p_id AND r_userid=$userid";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $PID = $row['p_id'];
                                                    $PNAME = $row['p_name'];
                                                    $TID = $row['request_id'];
                                                    //$TINFO = $row['request_info'];
                                                    //$TDESC = $row['request_desc'];
                                                    $TTOPIC = $row['request_topic'];
                                                    $TPRIORITY = $row['request_priority'];
                                                    $TSTATUS = $row['request_status'];
                                                    $TCREATED = $row['request_time'];
                                                    //$TDEADLINE = $row['request_deadline_time'];
                                            ?>
                                                    <tr>
                                                        <td><a style="color: #36b9cc;" href="ticketdetailproject.php?GetPro=<?php echo $PID ?>"><?php echo $PNAME ?></a></td>
                                                        <td><a style="color: #36b9cc;" href="tickettopicdetail.php?GetTopic=<?php echo $TID ?>"><?php echo $TTOPIC ?></a></td>
                                                        <td><?php echo $TPRIORITY ?></td>
                                                        <td><?php echo $TSTATUS ?></td>
                                                        <td><?php echo $TCREATED ?></td>
                                                        <!--<td><?php echo $TDEADLINE ?></td>-->
                                                        <!--<td><a href="edit.php?GetID=<?php echo $PID ?>">Edit</a></td>-->
                                                        <td><a href="editticket.php?GetID=<?php echo $TID ?>" class = "btn btn-warning">Edit</a> </td>
                                                        <!--<td><a href="ticketdelete.php?Del=<?php echo $TID ?>" class = "btn btn-danger">Delete</a></td>-->
                                                        <td><a href="ticketdetail.php?TDetail=<?php echo $TID ?>" class = "btn btn-success">Details</a></td>
                                                    </tr>
                                            <?php
                                                }
                                                echo "</table>";
                                            } else {
                                                echo "NO RESULT";
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


        <!--<script src="../assets/js/main.js"></script>-->
        <!--<script src="../assets/js/dashboard.js"></script>-->
        <!--<script src="../assets/js/mainjs.js"></script>-->
        <!--<script src="../assets/js/widgets.js"></script>-->

        <!--Local Stuff-->
        <script>
            // Datatable script
            $(document).ready(function() {
                $('#myTable').DataTable();
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