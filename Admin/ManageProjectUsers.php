<?php
// TO SET UP CONNECTION WITH dbconnection.php
include('../dbconnection.php');
//To start or resume existing session.
session_start();

if (isset($_POST['insert'])) {
    //modal box add new project starts
    if (($_POST['projectname'] == "")) {
        echo '<script type="text/javascript">alert("Fill all fields")</script>';
    } else {
        $pname = $_POST['projectname'];

        $sql = "INSERT INTO project_db(p_name)VALUES('$pname')";
        if ($conn->query($sql) == TRUE) {
            echo '<script type="text/javascript">alert("submitted successfully")</script>';
        } else {
            echo '<script type="text/javascript">alert("unable to submit your request")</script>';
        }
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
                    <li class="nav-item">
                        <a href="ManageRoleAssign.php"><i class="menu-icon fa fa-user-plus"></i>Manage Role Assignment </a>
                    </li>
                    <li class="active bg-primary" style="color: white;">
                        <a style="color: white;" href="ManageProjectUser.php"><i style="color: white;" class="menu-icon fa fa-square"></i>Manage Project Users </a>
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
                    <a class="navbar-brand" style="font-size: 18px; padding-left:15px; color:#337ab7" href="index.php">Bug Tracker</a>
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
                                    ?>   <i class="fa fa-check"></i>
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
            <div class="d-flex justify-content-end ">
                <button type="button" style="margin-bottom:15px; border-radius:16px;" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">+ ADD NEW PROJECT</button>
            </div>

            <!-- Modal content-->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create New Project</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form id="myform" method="POST">
                                <!--action="insertadmincode.php"-->
                                <div class="form-group">
                                    <label for="projectName">Project Name</label>
                                    <input type="text" class="form-control" id="projectname" name="projectname" aria-describedby="projectname" placeholder="Enter project">
                                </div>

                                <div class="form-group">
                                    <label for="projectDesc">Project Description</label>
                                    <input type="text" class="form-control" id="projectdesc" name="projectdesc" placeholder="Project Description">
                                </div>
                                <div>
                                    <input type="submit" name="insert" id="insert" class="btn btn-primary" value="Save Changes">
                                </div>
                            </form>

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
                                <div class="card-header p-4 bg-primary" style="color: white;">MANAGE PROJECTS</div>
                                <div class="card-body">
                                    <table class="table table-bordered mt-5" id="MyTable" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="text-align:center;">Projects</th>
                                                <th scope="col" style="text-align:center;">Member List</th>
                                                <th scope="col" style="text-align:center;">Edit</th>
                                                <th scope="col" style="text-align:center;">Delete</th>
                                                <th scope="col" style="text-align:center;">Detail</th>
                                            </tr>
                                       </thead>
                                        <tbody style="text-align:center;background-color:white;">

                                            <?php
                                            $sql = "SELECT p_id, p_name, p_desc FROM  project_db";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $PID = $row['p_id'];
                                                    $PNAME = $row['p_name'];
                                                    $PDESC = $row['p_desc'];
                                            ?>

                                                    <tr>
                                                        <td><?php echo $PNAME ?></td>
                                                        <td><a href="group.php?pid=<?php echo $row['p_id'] ?>" class = "btn btn-info"><span class = "glyphicon glyphicon-eye-open"></span>Membership</a></td>
                                                        <td><a href="edit.php?GetID=<?php echo $PID ?>" class = "btn btn-warning">Edit</a></td>
                                                        <td><a href="delete.php?Del=<?php echo $PID ?>" class = "btn btn-danger">Delete</a></td>
                                                        <td><a href="projectdetail.php?Detail=<?php echo $PID ?>" class = "btn btn-success">Details</a></td>
                                                    </tr>
                                            <?php
                                                }
                                                echo "</table>";
                                            } else {
                                                echo " NO RESULT";
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

    <!--<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>-->
    <!--<script src="../assets/js/main.js"></script>-->
    <!--<script src="../assets/js/dashboard.js"></script>-->
    <!--<script src="../assets/js/mainjs.js"></script>-->

    <!--Local Stuff-->
    <script>
        //modal box to add project
    </script>

    <script>
        // Datatable script
        jQuery(document).ready(function($) {
            $('#MyTable').DataTable();
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