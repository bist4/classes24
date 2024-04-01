<?php
require('../config/db_connection.php');
include('../security.php');// Start the session

// Check if the user is logged in
if (isset($_SESSION['Username'])) {
    $loggedInName = $_SESSION['Username'];

    $query = "SELECT is_Lock_Account, UserTypeID FROM userinfo WHERE Username = '$loggedInName' AND UserTypeID = 2";
    // Execute the query
    $result = $conn->query($query);
    
    if ($result) {
        $row = $result->fetch_assoc();

        // Close the result set
        $result->close();

        if ($row['UserTypeID'] == 2) {
        } else {
            header("location: ../index.php");
            // Optionally, you can include a link to log out and return to the login page
        }
    } else {
        // Handle the case where the query fails
        echo "Error in fetching RoleID and UserID: " . $conn->error;
    }
    
    // Close the database connection
    $conn->close();
}
if ($row['is_Lock_Account'] == 1) {
    // User account is locked
    header("Location: session_ended.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <link rel="icon" href="../assets/img/logo1.png">
        <!-- Style for icons and fonts -->
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
        
        <link href="../css/sb-admin-2.min.css" rel="stylesheet">
        <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script src="../assets/js/alert.js"></script>
        <title>Trash - Utilities</title>

    </head>

    <?php
    include('session_out.php');
    ?>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../system_admin.php">
                    <div class="sidebar-brand-icon">
                        <i class="fas">
                            <img src="../assets/img/logo1.png" alt="logo" width="50" height="50">
                        </i>
                    </div>
                    <div class="sidebar-brand-text mx-3" style="font-size: 13px">Online Class Scheduling System</div>
                </a>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="../system_admin.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    
                </div>

                <!-- Nav Item - File Maimntenance Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>File Maintenance</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="../filemaintenance/file_strand.php">Strand</a>
                            <a class="collapse-item" href="../filemaintenance/file_subject.php">Subject</a>
                            <a class="collapse-item" href="../filemaintenance/file_instructor.php">Instructor</a>
                            <a class="collapse-item" href="../filemaintenance/file_section.php">Class Section</a>
                            <a class="collapse-item" href="../filemaintenance/file_room.php">Room</a>
                            <a class="collapse-item" href="../filemaintenance/timeAvail.php">Instructor Availability</a>

                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseView"
                        aria-expanded="true" aria-controls="collapseView">
                        <i class="fas fa-fw fa-eye"></i>
                        <span>View Records</span>
                    </a>
                    <div id="collapseView" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="../records/view_strand.php">Strand</a>
                            <a class="collapse-item" href="../records/view_subject.php">Subject</a>
                            <a class="collapse-item" href="../records/view_instructor.php">Instructor</a>
                            <a class="collapse-item" href="../records/view_section.php">Class Section</a>
                            <a class="collapse-item" href="../records/view_room.php">Room</a>
                            <a class="collapse-item" href="../records/view_timeAvail.php">Instructor Availability</a>

                        </div>
                    </div>
                </li>


                <!-- Nav Item - Utilities Collapse Menu -->
                <li class="nav-item active">
                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                        aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>Utilities</span>
                    </a>
                    <div id="collapseUtilities" class="collapse show" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            
                            <a class="collapse-item" href="accounts.php">Account Management</a>
                            <a class="collapse-item" href="archive.php">Archive</a>
                            <a class="collapse-item" href="backup.php">Backup</a>
                            <a class="collapse-item" href="logs.php">Activity History</a>
                            <a class="collapse-item active" href="trash.php">Trash</a>

                        </div>
                    </div>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

            </ul>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                        <!-- Sidebar Toggle (Topbar) -->
                        <form class="form-inline">
                            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                                <i class="fa fa-bars"></i>
                            </button>
                        </form>


                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">
                            

                           
                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                    <img class="img-profile rounded-circle"
                                        src="../img/undraw_profile.svg">
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="../Profile/profile.php">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Profile
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>

                        </ul>

                    </nav>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-2 text-gray-800">Trash</h1>
                            
                        </div>
                    
                       
                        
                        <!-- DataTales Example -->

                        <!-- Strand Table -->
                        <div class="card shadow mb-4">
                            <div class="card" id="userCard">
                                <div class="card-header">
                                    <h5 class="card-title">Strand</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Click here to view the trashed data.</p>
                                    <!-- <button class="btn btn-primary" id="buttonId" onclick="toggleTable('userTableInstructor', 'buttonId')">View Instructor</button> -->
                                    <button class="btn btn-primary" id="buttonStrand" onclick="toggleTable('userTableStrand', 'buttonStrand', 'userTableInsTructor')">View</button>
                                    
                                </div>
                            </div>

                            <div class="card mt-3" id="userTableStrand" style="display: none;">
                                <div class="card-header">
                                    <h5 class="card-title">Strand Table</h5>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Strand Code</th>
                                                <th>Strand Name</th>
                                                <th>Track Type</th>
                                                <th>Specialization</th>
                                                <th>Action</th>
					                        </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Strand Code</th>
                                                <th>Strand Name</th>
                                                <th>Track Type</th>
                                                <th>Specialization</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                                require('../config/db_connection.php');
                                                $table = mysqli_query($conn,  "SELECT * FROM strands 
                                                WHERE strands.Active = 0");

                                                $count = 0;
                                                while ($row = mysqli_fetch_array($table)) {
                                                    $count++;
                                                   
                                                ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>
                                                        <td><?php echo $row['StrandCode']; ?></td>
                                                        <td><?php echo $row['StrandName']; ?></td>
                                                        <td><?php echo $row['TrackTypeName']; ?></td>
                                                        <td><?php echo $row['Specialization']; ?></td>
                                                        
                                                        <td>
                                                            <div class="d-flex justify-content-center">                                                          
                                                                <button class="btn btn-primary mx-2 btn-reply" data-toggle="modal" 
                                                                    data-strand-id="<?php echo $row['StrandID']; ?>"
                                                                    data-strand-code="<?php echo $row['StrandCode']; ?>"
                                                                    data-strand-name="<?php echo $row['StrandName']; ?>"
                                                                    data-track-type="<?php echo $row['TrackTypeName']; ?>"
                                                                    data-specialization="<?php echo $row['Specialization']; ?>">
                                                                    <i class="fa fa-reply" data-toggle="tooltip" data-placement="top" title="Retrieve Strand"></i>
                                                                </button>
                                                                <a href="#" class="btn btn-danger mx-2 btn-delete" data-strand-id="<?php echo $row['StrandID']; ?>">
                                                                    <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete Strand"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            ?> 
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    
                         <!-- Subject Table -->
                        <div class="card shadow mb-4">
                            <div class="card" id="userCard">
                                <div class="card-header">
                                    <h5 class="card-title">Subject</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Click here to view the trashed data.</p>
                                    <!-- <button class="btn btn-primary" id="buttonId" onclick="toggleTable('userTableInstructor', 'buttonId')">View Instructor</button> -->
                                    <button class="btn btn-primary" id="buttonSubject" onclick="toggleTable('userTableSubject', 'buttonSubject', 'userTableRoom')">View</button>
                                </div>
                            </div>

                            <div class="card mt-3" id="userTableSubject" style="display: none;">
                                <div class="card-header">
                                    <h5 class="card-title">Subject Table</h5>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Subject Code</th>
                                                <th>Subject Name</th>
                                                <th>Minutes Per Week</th>
                                                <th>Action</th>
					                        </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Subject Code</th>
                                                <th>Subject Name</th>
                                                <th>Minutes Per Week</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                                require('../config/db_connection.php');
                                                $table = mysqli_query($conn, "SELECT * FROM subjects 
                                                WHERE subjects.Active = 0");

                                                $count = 0;
                                                while ($row = mysqli_fetch_array($table)) {
                                                    $count++;
                                                     
                                                    
                                                ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>
                                                        <!-- <td><?php echo $row['DepartmentTypeName']; ?></td> -->
                                                        <td><?php echo $row['SubjectCode']; ?></td>
                                                        <td><?php echo $row['SubjectName']; ?></td>
                                                        <td><?php echo $row['MinutesPerWeek']; ?></td>
                                                        <td>
                                                        <div class="d-flex justify-content-center">
                                                            <!-- <a href="#" class="btn btn-primary mx-2"><i class="fa fa-edit"></i></a> -->
                                                            <button class="btn btn-primary mx-2 btn-reply" data-toggle="modal"
                                                                    data-subject-id="<?php echo $row['SubjectID']; ?>"
                                                                   
                                                                    data-subject-code="<?php echo $row['SubjectCode']; ?>"
                                                                    data-subject-description="<?php echo $row['SubjectName']; ?>"
                                                                    data-units="<?php echo $row['MinutesPerWeek']; ?>">
                                                                <i class="fa fa-reply" data-toggle="tooltip" data-placement="top" title="Retriecve Subject"></i>
                                                            </button>
                                                            <a href="#" class="btn btn-danger mx-2 btn-delete" data-subject-id="<?php echo $row['SubjectID']; ?>">
                                                                <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete Subject"></i>
                                                            </a>
                                                        </div>

                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            ?> 

                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Section Table -->
                        <div class="card shadow mb-4">
                             <!-- Section -->
                             <div class="card" id="userCard">
                                <div class="card-header">
                                    <h5 class="card-title">Class Section</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Click here to view the trashed data.</p>
                                    <!-- <button class="btn btn-primary" id="buttonId" onclick="toggleTable('userTableRoom', 'buttonId')">View Room</button> -->
                                    <button class="btn btn-primary" id="buttonSection" onclick="toggleTable('userTableSection', 'buttonSection', 'userTableInstructor')">View</button>
                                
                                </div>

                            </div>
                           

                            <div class="card mt-3" id="userTableSection" style="display: none;">
                                <div class="card-header">
                                    <h5 class="card-title">Section Table</h5>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Section Number</th>
                                                <th>Section Name</th>
                                                <th>Action</th>
					                        </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Section Number</th>
                                                <th>Section Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                                require('../config/db_connection.php');
                                                $table = mysqli_query($conn, "SELECT *  FROM classsections 
                                                where Active=0");

                                                $count = 0;
                                                while ($row = mysqli_fetch_array($table)) {
                                                    $count++;
                                                     
                                                ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>
                                                        <td><?php echo $row['SectionNo']; ?></td>
                                                        <td><?php echo $row['SectionName']; ?></td>
                                                        
                                                        <td>
                                                        <div class="d-flex justify-content-center">
                                                            <!-- <a href="#" class="btn btn-primary mx-2"><i class="fa fa-edit"></i></a> -->
                                                            <button class="btn btn-primary mx-2 btn-reply" data-toggle="modal" 
                                                                    data-section-id="<?php echo $row['SectionID']; ?>"
                                                                    data-section-number="<?php echo $row['SectionNo']; ?>"
                                                                    data-section-name="<?php echo $row['SectionName']; ?>">
                                                                <i class="fa fa-reply" data-toggle="tooltip" data-placement="top" title="Retrieve Section"></i>
                                                            </button>
                                                            <a href="#" class="btn btn-danger mx-2 btn-delete" data-section-id="<?php echo $row['SectionID']; ?>">
                                                                <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete Section"></i>
                                                            </a>
                                                        </div>

                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            ?> 

                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Room Table -->
                        <div class="card shadow mb-4">
                             <!-- Room -->
                             <div class="card" id="userCard">
                                <div class="card-header">
                                    <h5 class="card-title">Room</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Click here to view the trashed data.</p>
                                    <!-- <button class="btn btn-primary" id="buttonId" onclick="toggleTable('userTableRoom', 'buttonId')">View Room</button> -->
                                    <button class="btn btn-primary" id="buttonRoom" onclick="toggleTable('userTableRoom', 'buttonRoom', 'userTableInstructor')">View</button>
                                </div>

                            </div>
                           

                            <div class="card mt-3" id="userTableRoom" style="display: none;">
                                <div class="card-header">
                                    <h5 class="card-title">Room Table</h5>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Room Number</th>
                                                <th>Capacity</th>
                                                <th>Room Type</th>
                                                <th>Action</th>
					                        </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Room Number</th>
                                                <th>Capacity</th>
                                                <th>Room Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                               require('../config/db_connection.php');
                                               $table = mysqli_query($conn, "SELECT * FROM rooms WHERE rooms.Active=0");

                                                $count = 0;
                                                while ($row = mysqli_fetch_array($table)) {
                                                    $count++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>
                                                        <td><?php echo $row['RoomNumber']; ?></td>
                                                        <td><?php echo $row['Capacity']; ?></td>
                                                        <td><?php echo $row['RoomTypeName']; ?></td>

                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <!-- <a href="#" class="btn btn-primary mx-2"><i class="fa fa-edit"></i></a> -->
                                                                <button class="btn btn-primary mx-2 btn-reply" data-toggle="modal" 
                                                                        data-room-id="<?php echo $row['RoomID']; ?>"
                                                                        data-room-number="<?php echo $row['RoomNumber']; ?>"
                                                                        data-capacity="<?php echo $row['Capacity']; ?>"
                                                                        data-room-type="<?php echo $row['RoomTypeName']; ?>">
                                                                    <i class="fa fa-reply" data-toggle="tooltip" data-placement="top" title="Retrirve Room"></i>
                                                                </button>
                                                                <a href="#" class="btn btn-danger mx-2 btn-delete" data-room-id="<?php echo $row['RoomID']; ?>">
                                                                    <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete Room"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            ?> 
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        
                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; BATANG COMTEQ 2023</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

                        <form action="../logout.php" method="POST">
                            <button type="submit"  name="logout_btn" class="btn btn-primary">Logout</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
 

        <!-- Bootstrap core JavaScript-->
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../assets/js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../assets/js/demo/datatables-demo.js"></script>
        <!-- For filtering of strands details -->
        <!-- <script src="../assets/js/filteringStrand.js"></script> -->

        <!-- loading -->
        <script>
            // Function to show the loading spinner and hide the Save button
            function showLoadingSpinner() {
                $("#saveButton").prop("disabled", true);
                $("#saveButton .spinner-border").removeClass("d-none");
            }

            // Function to hide the loading spinner and show the Save button
            function hideLoadingSpinner() {
                $("#saveButton").prop("disabled", false);
                $("#saveButton .spinner-border").addClass("d-none");
            }

            // Handle form submission
            $("#addStrandForm").submit(function (event) {
                // Prevent the form from submitting immediately
                event.preventDefault();

                // Show the loading spinner
                showLoadingSpinner();

                // Submit the form after a short delay to simulate loading
                setTimeout(function () {
                    this.submit();
                }.bind(this), 2000); // Adjust the delay as needed

                // If you want to submit the form without the delay, remove the setTimeout function and simply use this.submit();
            });
        </script>

        <!-- Print and Import to Excel -->
        <script src="../assets/js/DataPrintExcel/print_subject.js"></script>
         
        <script src="../assets/js/table.js"></script>

       
       
       <!-- Include jQuery library -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../assets/js/jquery-3.6.0.min.js"></script>
        <!-- Include SweetAlert library -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../assets/js/alert11.js"></script>

        

        <script>
            $(document).ready(function() {
                // Handle click event on the "Room" button
                $('.btn-reply[data-room-id]').click(function() {
                    var roomID = $(this).data('room-id');
                    var dataToSend = {
                        RoomID: roomID
                    };

                    

                    // Show confirmation dialog
                    Swal.fire({
                        title: 'Are your sure?',
                        text: 'You are about to restore this room.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'Cancel',
                        cancelButtonColor: '#d33',
                        reverseButtons: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // User confirmed, send AJAX request
                            var loading = Swal.fire({
                                title: 'Please wait',
                                html: 'Restoring your data...',
                                allowOutsideClick: false,
                                showConfirmButton: false, 
                                onBeforeOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            $.ajax({
                                type: 'POST',
                                url: 'DataRetrieve/retrieve_room.php',
                                data: dataToSend,
                                success: function(response) {
                                    response = JSON.parse(response);
                                    loading.close();
                                    if (response.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: response.success,
                                            showConfirmButton: false,
                                            timer: 2000
                                        }).then(function() {
                                            window.location.href = 'trash.php';
                                        });
                                    } else if (response.error) {
                                        loading.close();
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Warning',
                                            text: response.error,
                                        });
                                    }
                                },
                                error: function() {
                                    loading.close();
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'An error occurred while retrieving data.',
                                    });
                                }
                            });
                        } 
                        // else if (result.dismiss === Swal.DismissReason.cancel) {
                        //     // User cancelled, do nothing
                        //     Swal.fire({
                        //         title: 'Cancelled',
                        //         text: 'Room restoration cancelled.',
                        //         icon: 'info',
                        //         showConfirmButton: false,
                        //         timer: 2000
                        //     }).then(function() {
                        //         window.location.href = 'trash.php';
                        //     });
                        // }
                    });
                });
            });
        </script>



        <!-- =====================Strand====================== -->
        <script>
            $(document).ready(function() {
                // Handle click event on the "Reply" button
                $('.btn-reply[data-strand-id]').click(function() {
                    var strandID = $(this).data('strand-id');
                    var dataToSend = {
                        StrandID: strandID
                    };

                    Swal.fire({
                        title: 'Are your sure?',
                        text: 'You are about to restore this strand.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'Cancel',
                        cancelButtonColor: '#d33',
                        reverseButtons: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var loading = Swal.fire({
                                title: 'Please wait',
                                html: 'Restoring your data...',
                                allowOutsideClick: false,
                                showConfirmButton: false, 
                                onBeforeOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                             // Send an AJAX request to update the Active status for the strand
                            $.ajax({
                                type: 'POST',
                                url: 'DataRetrieve/retrieve_strand.php',
                                data: dataToSend,
                                success: function(response) {
                                    try {
                                        response = JSON.parse(response);
                                        loading.close();
                                        if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success',
                                                text: response.success,
                                                showConfirmButton: false, 
                                                timer: 2000
                                            }).then(function() {
                                                window.location.href = 'trash.php';
                                            });
                                        } else if (response.error) {
                                            loading.close();
                                            Swal.fire({
                                                icon: 'warning',
                                                title: 'Warning',
                                                text: response.error,
                                            });
                                        } else {
                                            loading.close();
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: 'An unknown error occurred while retrieving data.',
                                            });
                                        }
                                    } catch (error) {
                                        // console.error('Error parsing response:', error);
                                        loading.close();
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'An error occurred while processing the response.',
                                        });
                                    }
                                },
                                error: function() {
                                    loading.close();
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'An error occurred while retrieving data.',
                                    });
                                }
                            });
                        }
                    });

                   
                });
            });
        </script>
        <!-- ===================END======================== -->
        <!-- =================Subject====================== -->
        <script>
            $(document).ready(function() {
                // Handle click event on the "Reply" button
                $('.btn-reply[data-subject-id]').click(function() {
                    var subjectID = $(this).data('subject-id');
                    var dataToSend = {
                        SubjectID: subjectID
                    };

                     // Show confirmation dialog
                     Swal.fire({
                        title: 'Are your sure?',
                        text: 'You are about to restore this subject.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'Cancel',
                        cancelButtonColor: '#d33',
                        reverseButtons: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // User confirmed, send AJAX request
                            var loading = Swal.fire({
                                title: 'Please wait',
                                html: 'Restoring your data...',
                                allowOutsideClick: false,
                                showConfirmButton: false, 
                                onBeforeOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                             // Send an AJAX request to update the Active status for the subject
                            $.ajax({
                                type: 'POST',
                                url: 'DataRetrieve/retrieve_subject.php',
                                data: dataToSend,
                                success: function(response) {
                                    try {
                                        response = JSON.parse(response);
                                        loading.close();
                                        if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success',
                                                text: response.success,
                                                showConfirmButton: false,
                                                timer: 2000
                                            }).then(function() {
                                                window.location.href = 'trash.php';
                                            });
                                        } else if (response.error) {
                                            loading.close();
                                            Swal.fire({
                                                icon: 'warning',
                                                title: 'Warning',
                                                text: response.error,
                                            });
                                        } else {
                                            loading.close();
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: 'An unknown error occurred while retrieving data.',
                                            });
                                        }
                                    } catch (error) {
                                        console.error('Error parsing response:', error);
                                        loading.close();
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'An error occurred while processing the response.',
                                        });
                                    }
                                },
                                error: function() {
                                    loading.close();
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'An error occurred while retrieving data.',
                                    });
                                }
                            });
                        } 
                        // else if (result.dismiss === Swal.DismissReason.cancel) {
                        //     // User cancelled, do nothing
                        //     Swal.fire({
                        //         title: 'Cancelled',
                        //         text: 'Room restoration cancelled.',
                        //         icon: 'info',
                        //         showConfirmButton: false,
                        //         timer: 2000
                        //     }).then(function() {
                        //         window.location.href = 'trash.php';
                        //     });
                        // }
                    });

                   
                });
            });
        </script>
        <!-- ====================End======================= -->

        <!-- ===================Section==================== -->
       
        <script>
            $(document).ready(function() {
                // Handle click event on the "Reply" button
                $('.btn-reply[data-section-id]').click(function() {
                    var sectionID = $(this).data('section-id');
                    var dataToSend = {
                        SectionID: sectionID
                    };

                    // Show confirmation message
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to restore this class section.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes!'
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            var loading = Swal.fire({
                                title: 'Please wait',
                                html: 'Restoring your data...',
                                allowOutsideClick: false,
                                showConfirmButton: false, 
                                onBeforeOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            // Send an AJAX request to update the Active status for the section
                            $.ajax({
                                type: 'POST',
                                url: 'DataRetrieve/retrieve_section.php',
                                data: dataToSend,
                                success: function(response) {
                                    try {
                                        response = JSON.parse(response);
                                        loading.close();
                                        if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success',
                                                text: response.success,
                                                timer: 2000, // Set the timer to 2000 milliseconds (2 seconds)
                                                showConfirmButton: false, // Hide the confirmation button
                                                allowOutsideClick: false // Prevent outside clicks from dismissing the alert
                                            }).then(function() {
                                                // Redirect to trash.php after the timer expires
                                                window.location.href = 'trash.php';
                                            });

                                        } else if (response.error) {
                                            loading.close();
                                            Swal.fire({
                                                icon: 'warning',
                                                title: 'Warning',
                                                text: response.error,
                                            });
                                        } else {
                                            loading.close();
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: 'An unknown error occurred while retrieving data.',
                                            });
                                        }
                                    } catch (error) {
                                        console.error('Error parsing response:', error);
                                        loading.close();
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'An error occurred while processing the response.',
                                        });
                                    }
                                },
                                error: function() {
                                    loading.close();
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'An error occurred while retrieving data.',
                                    });
                                }
                            });
                        }
                    });
                });
            });
        </script>

        <!-- ====================END======================= -->


            
        <!-- Delete Query -->
        <script>
            $(document).ready(function() {
                // Handle click event on the "Delete" button
                $('.btn-delete').click(function() {
                    var deleteButton = $(this); // Store the reference to the delete button

                   

                    // Show a confirmation dialog
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to delete this item.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then((result) => {

                       
                        if (result.isConfirmed) {

                            var loading = Swal.fire({
                                title: 'Please wait',
                                html: 'Deleting your data...',
                                allowOutsideClick: false,
                                showConfirmButton: false, 
                                onBeforeOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Retrieve the data attributes
                            var instructorID = deleteButton.data('instructor-id');
                            var roomID = deleteButton.data('room-id');
                            var strandID = deleteButton.data('strand-id');
                            var subjectID = deleteButton.data('subject-id');
                            var sectionID = deleteButton.data('section-id');

                            // Determine whether to update an instructor or a room
                            var dataToSend = {};
                            if (instructorID !== undefined) {
                                dataToSend = {
                                    InstructorID: instructorID
                                };
                            } else if (strandID !== undefined) {
                                dataToSend = {
                                    StrandID: strandID
                                };
                            } else if (subjectID !== undefined) {
                                dataToSend = {
                                    SubjectID: subjectID
                                };
                            } else if (sectionID !== undefined) {
                                dataToSend = {
                                    SectionID: sectionID
                                };
                            } else if (roomID !== undefined) {
                                dataToSend = {
                                    RoomID: roomID
                                };
                            }

                            // Send an AJAX request to your delete_room.php script
                            $.ajax({
                                type: 'POST',
                                url: 'DataDelete/archive_delete.php', // Replace with the actual URL for your server-side script
                                data: dataToSend,
                                success: function(response) {
                                    // Handle the response from the server
                                    loading.close();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        showConfirmButton: false,
                                        text: response, // Message from the server
                                        timer: 2000 // Set the timer to close the alert after 2 seconds
                                    }).then(function() {
                                        window.location.href = 'trash.php';
                                    });

                                },
                                error: function() {
                                    // Handle errors, if any
                                    loading.close();
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'An error occurred while deleting.'
                                    });
                                }

                            });
                        }
                    });
                });
            });
        </script>



        <script>
        
        
            function toggleTable(tableId, buttonId, otherTableId) {
                // Your logic to toggle table visibility based on IDs
                // Fetch elements by IDs and toggle their display property
                // For instance:
                var table = document.getElementById(tableId);
                var otherTable = document.getElementById(otherTableId);
                if (table.style.display === 'none') {
                    table.style.display = 'block';
                    if (otherTable) {
                        otherTable.style.display = 'none';
                    }
                } else {
                    table.style.display = 'none';
                }
            }

        </script>


 

    </body>

</html>