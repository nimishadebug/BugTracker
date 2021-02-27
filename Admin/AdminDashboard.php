 <?php
    // TO SET UP CONNECTION WITH dbconnection.php
    include('../dbconnection.php');
    //To start or resume existing session.
    session_start();
    //var_dump($_SESSION);


    if (isset($_SESSION['login'])) {
        echo $_SESSION['login'];
        $userid = $_SESSION["r_login_id"];
        $rEmail = $_SESSION['rEmail'];
        if ($_SESSION['login'] != NULL) {
        } else {
            echo "<script>location.href= '../UserLogin.php'</script>";
        }
    }
    //AND r_developer = $userid 
    $sql = mysqli_query($conn, "SELECT submitrequest_db.p_id, project_db.p_id, project_db.p_name FROM submitrequest_db, project_db WHERE submitrequest_db.admin_ticket_status = 0 AND submitrequest_db.p_id = project_db.p_id ");
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

     <style>
         .card-box:hover {
             transform: scale(1.05);
             box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
         }

         .cardbg:hover {
             transform: scale(1.05);
             box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
         }
     </style>

 </head>



 <body>

     <!-- Left Panel -->
     <aside id="left-panel" class="left-panel">
         <nav class="navbar navbar-expand-sm navbar-default" style="background-color:#f8f8f8;">
             <div id="main-menu" class="main-menu collapse navbar-collapse">
                 <ul class="nav navbar-nav">
                     <li class="active bg-primary" style="padding-top:15px;color:white;">
                         <a style="color: white;" href="AdminDashboard.php"><i style="color: white;" class="menu-icon fa fa-laptop"></i>Dashboard </a>
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
                     <li class="nav-item">
                         <a href="UserList.php"><i class="menu-icon fa fa-users"></i>User List </a>
                     </li>
                     <li class="nav-item">
                         <a href="comments.php"><i class="menu-icon fa fa-comment"></i>Comments</a>
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
                             <a class="nav-link" href="ChangePassword.php"><i class="fa fa- user"></i>My Profile</a>

                             <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">13</span></a>

                             <a class="nav-link" href="ChangePassword.php"><i class="fa fa -cog"></i>Settings</a>

                             <a class="nav-link" href="AdminLogout.php"><i class="fa fa-power -off"></i>Logout</a>
                         </div>
                     </div>

                 </div>
             </div>
         </header>
         <!-- /#header -->
         <!-- Content Starts-->
         <div class="content">
             <div class="row mx-5 text-center">
                 <div class="col-sm-3 text-white mt-5">
                     <div class="card box card-box p-2 bg-info text-white mb-3; max-width:18rem;">
                         <div class="card-header text-white">Tickets Recieved</div>
                         <div class="card-body">
                             <div class="align-self-center">
                                 <i class="icon-envelope float-left" style="font-size: 3.5rem;"></i>
                             </div>
                             <h3 class="card-title text-white text-right" style="font-size:3.5rem;">12</h3>
                         </div>
                     </div>
                 </div>

                 <div class="col-sm-3 mt-5 text-white">
                     <div class="card box card-box p-2 bg-primary text-white mb-3; max-width:18rem;">
                         <div class="card-header text-white">No. of Users</div>
                         <div class="card-body">
                             <div class="align-self-center">
                                 <i class="icon-user-following float-left text-white" style="font-size: 3.5rem;"></i>
                             </div>
                             <h3 class="card-title text-white text-right" style="font-size:3.5rem;">12</h3>
                         </div>
                     </div>
                 </div>

                 <div class="col-sm-3 mt-5 text-center">
                     <div class="card box card-box p-2 bg-success text-whte mb-3 ; max-width:18rem;">
                         <div class="card-header text-white">No. of Managers</div>
                         <div class="card-body">
                             <div class="align-self-center">
                                 <i class="icon-user float-left text-white" style="font-size: 3.5rem;"></i>
                             </div>
                             <h3 class="card-title text-white text-right" style="font-size:3.5rem;">8</h3>
                         </div>
                     </div>
                 </div>

                 <div class="col-sm-3 mt-5 text-center">
                     <div class="card box card-box p-2 bg-warning text-white mb-3 ; max-width:18rem;">
                         <div class="card-header text-white">No. of developers</div>
                         <div class="card-body">
                             <div class="align-self-center">
                                 <i class="icon-wrench float-left" style="font-size: 3.5rem;"></i>
                             </div>
                             <h3 class="card-title text-white text-right" style="font-size:3.5rem;">12</h3>
                         </div>
                     </div>
                 </div>
             </div>


             <!--Ticket charts-->

             <div class="chart-row" style="margin-top: 23px;">
                 <div class="row">

                     <div class="col-lg-6">
                         <div class="card">
                             <div class="text-center">
                                 <div class="card-header bg-primary">
                                     <h6 style="color: white;">TICKET STATUS</h6>
                                 </div>
                                 <div class="card-body">
                                     <canvas id="myChart"></canvas>
                                 </div>
                             </div>
                         </div>
                     </div>

                     <div class="col-lg-6">
                         <div class="card">
                             <div class="text-center">
                                 <div class="card-header bg-primary">
                                     <h6 style="color: white;">TICKET PRIORITY</h6>
                                 </div>
                                 <div class="card-body">
                                     <canvas id="myDoughnut"></canvas>
                                 </div>
                             </div>
                         </div>
                     </div>

                 </div>
             </div>

             <div class=data-row style="margin-top: 20px;">
                 <div class="row" style="margin-bottom:50px;">
                     <div class="col-lg-12">
                         <div class="card" style="color:#5777ba;">
                             <div class="mx-5 mt-5 text-center">
                                 <div class="card-header p-4 bg-primary" style="color: white;">
                                     LIST OF USERS
                                 </div>
                                 <div class="card-body">

                                     <table class="table display table-bordered table-hover" style="width:100%">
                                         <thead>
                                             <tr>
                                                 <th scope="col" style="text-align:center;">Id</th>
                                                 <th scope="col" style="text-align:center;">Username</th>
                                                 <th scope="col" style="text-align:center;">Email</th>
                                                 <th scope="col" style="text-align:center;">Role</th>
                                             </tr>
                                         </thead>

                                         <tbody>
                                             <?php

                                                $sql = "SELECT r_login_id, r_name, r_email, r_select FROM  userregistration_db ";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    //$_SESSION['rSelect'] = $rSelect;
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr><td>" . $row["r_login_id"] . "</td><td>" . $row["r_name"] . "</td><td>" . $row["r_email"] . "</td><td>" . $row["r_select"] . "</td></tr>";
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

             <div class="row" style="margin-bottom:15px;">
                 <div class="col-lg-6">
                     <div class="card cardbg">
                         <div class="text-center">
                             <a href="ManageRoleAssign.php">
                                 <div class="card-header bg-primary">
                                     <h6 style="color: white;">MANAGE ROLES</h6>
                                     <i class="fa fa-arrow-right" style="float:right;position:relative;top:-20px;"></i>
                                 </div>
                             </a>
                         </div>
                     </div>
                 </div>

                 <div class="col-lg-6">
                     <div class="card cardbg">
                         <div class="text-center">
                             <a href="ManageProjectUsers.php">
                                 <div class="card-header bg-primary">
                                     <h6 style="color: white;">MANAGE PROJECTS</h6>
                                     <i class="fa fa-arrow-right" style="float:right;position:relative;top:-20px;"></i>
                                 </div>
                             </a>
                         </div>
                     </div>
                 </div>
             </div>


             <div class="row" style="margin-bottom:0px;">
                 <div class="col-lg-12">
                     <div class="card" style="color:#5777ba;">
                         <div class="mx-5 mt-5 text-center">
                             <div class="card-header p-4 bg-primary" style="color: white;">
                                 ALL TICKETS
                             </div>
                             <div class="card-body">
                                 <table class="table display table-bordered table-hover" style="width:100%">
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
                                            //$sql = "SELECT r_login_id, r_name, r_email, r_select FROM  userregistration_db";
                                            $sql = "SELECT project_db.p_id, project_db.p_name, submitrequest_db.request_id, submitrequest_db.request_info, submitrequest_db.request_topic, submitrequest_db.request_priority, submitrequest_db.request_status, submitrequest_db.request_time FROM project_db, submitrequest_db WHERE project_db.p_id=submitrequest_db.p_id ";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr><td>" . $row["p_name"] .  "</td><td>" . $row["request_topic"] . "</td><td>" . $row["request_info"] . "</td><td>" . $row["request_priority"] . "</td><td>" . $row["request_time"] . "</td></tr>";
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

                 <div class="col-lg-12" style="margin-bottom: 50px;">
                     <div class="card" style="color:#5777ba;">
                         <div class="mx-5 mt-5 text-center">
                             <div class="card-header p-4 bg-primary" style="color: white;">
                                 MY TICKETS
                             </div>
                             <div class="card-body">
                                 <table class="table display table-bordered table-hover" style="width:100%">

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
                                                         FROM project_db, submitrequest_db WHERE project_db.p_id=submitrequest_db.p_id AND r_userid={$_SESSION['r_login_id']}";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {

                                                    echo "<tr><td>" . $row["p_name"] .  "</td><td>" . $row["request_topic"] . "</td><td>" . $row["request_info"] . "</td><td>" . $row["request_priority"] . "</td><td>" . $row["request_time"] . "</td></tr>";
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
     <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>

     <!--<script src="../assets/js/main.js"></script>-->
     <!--<script src="../assets/js/dashboard.js"></script>-->
     <!--<script src="../assets/js/mainjs.js"></script>-->

     <!--Local Stuff-->
     <script>
         $(document).ready(function() {
             //$('#myTable.display').DataTable({
             $('table.display').DataTable({
                 "pagingType": "full_numbers"
             });
         });

         var ctx = document.getElementById('myChart').getContext('2d');
         var myChart = new Chart(ctx, {
             type: 'bar',
             data: {
                 labels: ['New', 'In Progress', 'Delayed', 'Unreleased', 'Released', 'Completed', 'Under Review', 'Final Review', 'Denied', 'Approved'],
                 datasets: [{
                     label: '# of Votes',
                     data: [10, 19, 13, 5, 22, 3, 5, 6, 1, 15],
                     backgroundColor: [
                         'rgba(255, 99, 132, 0.2)',
                         'rgba(54, 162, 235, 0.2)',
                         'rgba(255, 206, 86, 0.2)',
                         'rgba(75, 192, 192, 0.2)',
                         'rgba(153, 122,255,0.2)',
                         'rgba(153, 86, 255, 0.2)',
                         'rgba(54, 255, 255, 0.2)',
                         'rgba(255, 159, 64, 0.2)'
                     ],
                     borderColor: [
                         'rgba(255, 99, 132, 1)',
                         'rgba(54, 162, 235, 1)',
                         'rgba(255, 206, 86, 1)',
                         'rgba(75, 192, 192, 1)',
                         'rgba(153, 102,255,1)',
                         'rgba(255, 159, 64, 1)'
                     ],
                     borderWidth: 1
                 }]
             },
             options: {
                 scales: {
                     yAxes: [{
                         ticks: {
                             beginAtZero: true
                         }
                     }]
                 }
             }
         });

         var ctx = document.getElementById('myDoughnut').getContext('2d');
         var myDoughnut = new Chart(ctx, {
             type: 'doughnut',
             data: {
                 labels: ['Low', 'Normal', 'High', 'Critical'],
                 datasets: [{
                     label: '# of Votes',
                     data: [12, 19, 3, 5],
                     backgroundColor: [
                         'rgba(255, 99, 132, 0.2)',
                         'rgba(54, 162, 235, 0.2)',
                         'rgba(153, 122,255,0.2)',
                         'rgba(75, 192, 192, 0.2)',
                     ],
                     borderColor: [
                         'rgba(255, 99, 132, 1)',
                         'rgba(54, 162, 235, 1)',
                         'rgba(153, 122,255,1)',
                         'rgba(75, 192, 192, 1)',
                     ],
                     borderWidth: 1
                 }]
             },
             options: {
                 scales: {
                     yAxes: [{
                         ticks: {
                             beginAtZero: true
                         }
                     }]
                 }
             }
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