<?php
require('../config/db_connection.php');
include('../security.php');
// Start the session

// Check if the user is logged in
if (isset($_SESSION['Username'])) {
    $loggedInName = $_SESSION['Username'];

    $query = "SELECT is_Lock_Account, is_SchoolDirectorAssistant FROM userinfo WHERE Username = '$loggedInName' AND is_SchoolDirectorAssistant = 1";
    // Execute the query
    $result = $conn->query($query);
    
    if ($result) {
        $row = $result->fetch_assoc();

        // Close the result set
        $result->close();

        if ($row['is_SchoolDirectorAssistant'] == 1) {
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
        <title>Modify Schedule</title>

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
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../assistant.php">
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
                    <a class="nav-link" href="../assistant.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    
                </div>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSchedule"
                        aria-expanded="true" aria-controls="collapseSchedule">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Create Schedule</span>
                    </a>
                    <div id="collapseSchedule" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="shs_create_schedule.php">Senior High School</a>
                            <a class="collapse-item" href="jhs_create_schedule.php">Junior High School</a>
                            <a class="collapse-item" href="primary_create_schedule.php">Primary</a>
                        </div>
                    </div>
                </li>

                <!-- Nav Item - File Maimntenance Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#"  data-toggle="collapse" data-target="#collapseDraft"
                        aria-expanded="true" aria-controls="collapseDraft">
                        <i class="fas fa-edit"></i>
                        <span>Draft Schedule</span>
                    </a>
                    <div id="collapseDraft" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="shs_draft_schedule.php">Senior High School</a>
                            <a class="collapse-item" href="jhs_draft_schedule.php">Junior High School</a>
                            <a class="collapse-item" href="primary_draft_schedule.php">Primary</a>
                        </div>
                    </div>
                </li>

                <!-- View Schedule Section -->
                <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseView"
                    aria-expanded="true" aria-controls="collapseView">
                    <i class="fas fa-fw fa-eye"></i>
                    <span>View Schedule</span>
                </a>
                <div id="collapseView" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="view_senior_high_school.php">Senior High School</a>
                        <a class="collapse-item" href="view_junior_high_school.php">Junior High School</a>
                        <a class="collapse-item" href="view_primary.php">Primary</a>
                        <a class="collapse-item" href="view_room.php">Room</a>
                        <a class="collapse-item" href="view_instructor.php">Instructor</a>
                    </div>
                </div>
            </li>

                <!-- Nav Item - View Menu -->
                <li class="nav-item active">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOfficial"
                        aria-expanded="true" aria-controls="collapseOfficial">
                        <i class="fas fa-fw fa-calendar-alt"></i>
                        <span>Modify Schedule</span>
                    </a>
                    <div id="collapseOfficial" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="shs_schedule.php">Senior High School</a>
                            <a class="collapse-item" href="jhs_schedule.php">Junior High School</a>
                            <a class="collapse-item active" href="primary_schedule.php">Primary</a>
                        </div>
                    </div>
                </li>

                <!-- Archive Section -->
                <li class="nav-item">
                    <a class="nav-link" href="archive_schedule.php">
                        <i class="fas fa-fw fa-archive"></i>
                        <span>Archive Schedule</span>
                    </a>
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

                        <!-- Topbar Search -->
                        <!-- <form
                            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                    aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form> -->

                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">                

                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Assistant</span>
                                    <img class="img-profile rounded-circle"
                                        src="../img/undraw_profile.svg">
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="../Profile/assistant_profile.php">
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

                        <div class="container mt-4">
                            <div class="row">
                                <div class="col-lg-12 col-md-6">
                                    <h1 style="font-size: 25px;">Primary Schedule</h1> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-6 mb-3 d-flex align-items-center">
                                    <label for="instructor" class="form-label mb-0 mr-2">Instructor:</label>
                                    <div class="flex-grow-1">
                                        <select id="instructor" class="form-control w-100" required>
                                            <option value="" disabled selected>Select Instructor</option>
                                                <?php
                                                    require('../config/db_connection.php');

                                                    // Assuming your table name is "strands" and the column is "TrackTypeName"
                                                    $sql = "SELECT DISTINCT Instructor FROM classschedule WHERE Active =  1 AND Department = 'Primary'";
                                                    $result = $conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo '<option value="' . $row['Instructor'] . '">' . $row['Instructor'] . '</option>';
                                                        }
                                                    echo '</select>';
                                                    } else {
                                                        echo '<p>No tracks found in the database</p>';
                                                    }

                                                    // Close the database connection
                                                    $conn->close();
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-3 d-flex align-items-center">
                                    <label for="room" class="form-label mb-0 mr-2">Room:</label>
                                    <div class="flex-grow-1">
                                        <select id="room" class="form-control w-100" required>
                                            <option value="" disabled selected>Select Room</option>
                                            <?php
                                                    require('../config/db_connection.php');

                                                    // Assuming your table name is "strands" and the column is "TrackTypeName"
                                                    $sql = "SELECT DISTINCT Room FROM classschedule WHERE Active =  1 AND Department = 'Primary'";
                                                    $result = $conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo '<option value="' . $row['Room'] . '">' . $row['Room'] . '</option>';
                                                        }
                                                    echo '</select>';
                                                    } else {
                                                        echo '<p>No tracks found in the database</p>';
                                                    }

                                                    // Close the database connection
                                                    $conn->close();
                                                ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex justify-content-end">
                                <div class="row">
                                    <div class="col-lg-12 col-md-6">
                                        <button id="requestRevision" class="btn btn-primary" onclick="requestRevision()">Request Revision</button>
                                        <button id="requestDrop" class="btn btn-primary" onclick="requestDrop()">Request Drop</button>
                                        <button id="editSchedule" class="btn btn-primary" style="display: none;" onclick="editSchedule()">Edit Schedule</button>
                                        <button id="dropSchedule" class="btn btn-danger" style="display: none;" onclick="dropSchedule()">Drop Schedule</button>
                                    </div>
                                </div>
                            </div>




                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Year Level</th>
                                                <th scope="col">Subject</th>
                                                <th scope="col">Time</th>
                                                <th scope="col">Day</th>
                                                <th scope="col">Instructor</th>
                                                <th scope="col">Room</th>
                                                <th scope="col">Section</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- <php
                                                require('../config/db_connection.php');

                                                // Assuming your table name is "classschedule" and the columns are as mentioned
                                                $sql = "SELECT * FROM classschedule WHERE Active = 1 AND Department = 'Primary'";
                                                $result = $conn->query($sql);

                                                $groupedRows = [];

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        $key = $row["YearLevel"] . '_' . $row["Semester"] . '_' . $row["Strand"] . '_' . $row["Time_Start"] . '_' . $row["Time_End"] . '_' . $row["Subject"] . '_' . $row["Instructor"] . '_' . $row["Room"] . '_' . $row["Section"];

                                                        if (!isset($groupedRows[$key])) {
                                                            $groupedRows[$key] = [
                                                                'YearLevel' => $row["YearLevel"],
                                                                'Semester' => $row["Semester"],
                                                                'Strand' => $row["Strand"],
                                                                'Time_Start' => $row["Time_Start"],
                                                                'Time_End' => $row["Time_End"],
                                                                'Day' => [],
                                                                'Subject' => $row["Subject"],
                                                                'Instructor' => $row["Instructor"],
                                                                'Room' => $row["Room"],
                                                                'Section' => $row["Section"],
                                                            ];
                                                        }

                                                        $groupedRows[$key]['Day'][] = $row["Day"];
                                                    }

                                                    // Custom sorting function
                                                    usort($groupedRows, function ($a, $b) {
                                                        // Compare Year Level
                                                        $yearLevelComparison = strcmp($a['YearLevel'], $b['YearLevel']);
                                                        if ($yearLevelComparison !== 0) {
                                                            return $yearLevelComparison;
                                                        }

                                                        // Compare Time
                                                        $timeStartA = strtotime($a['Time_Start']);
                                                        $timeStartB = strtotime($b['Time_Start']);

                                                        if ($timeStartA !== $timeStartB) {
                                                            return $timeStartA - $timeStartB;
                                                        }

                                                        // If times are the same, compare Days
                                                        $daysA = reset($a['Day']);
                                                        $daysB = reset($b['Day']);

                                                        $orderOfDays = ['M' => 1, 'T' => 2, 'W' => 3, 'TH' => 4, 'F' => 5];
                                                        $dayOrderA = $orderOfDays[$daysA];
                                                        $dayOrderB = $orderOfDays[$daysB];

                                                        return $dayOrderA - $dayOrderB;
                                                    });

                                                    foreach ($groupedRows as $groupedRow) {
                                                        echo "<tr>";
                                                        echo "<td>" . $groupedRow["YearLevel"] . "</td>";
                                                        echo "<td>" . $groupedRow["Subject"] . "</td>";
                                                        echo "<td>" . date("h:ia", strtotime($groupedRow["Time_Start"])) . ' - ' . date("h:ia", strtotime($groupedRow["Time_End"])) . "</td>";
                                                        echo "<td>" . implode(', ', $groupedRow["Day"]) . "</td>";
                                                        echo "<td>" . $groupedRow["Instructor"] . "</td>";
                                                        echo "<td>" . $groupedRow["Room"] . "</td>";
                                                        echo "<td>" . $groupedRow["Section"] . "</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='9'>No data found</td></tr>";
                                                }

                                                // Close the database connection
                                                $conn->close();
                                            ?> -->
                                        </tbody>
                                    </table>
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

        <!-- reject modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to reject?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger">Yes</button>
                    </div>
                </div>
            </div>
        </div>

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
        <script src="../assets/js/filteringStrand.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        
        <script>
    $(document).ready(function () {
        // Handle changes in the instructor and room select elements
        // $('#instructor, #room').change(function () {
        //     // Get the selected values
        //     var instructor = $('#instructor').val();
        //     var room = $('#room').val();

        //     // Make an AJAX request to fetch data based on both selections
        //     $.ajax({
        //         url: 'View/shs_instructor_room.php', // Replace with the actual PHP script URL
        //         method: 'POST',
        //         data: { instructor: instructor, room: room },
        //         success: function (data) {
        //             // Update the table body with the fetched data
        //             $('tbody').html(data);
        //         },
        //         error: function () {
        //             alert('Error fetching data');
        //         }
        //     });
        // });

        // Handle changes in the instructor select element
        $('#instructor').change(function () {
            // Get the selected instructor
            var instructor = $(this).val();

            // Make an AJAX request to fetch instructor-related data
            $.ajax({
                url: 'View/primary_instructor.php', // Replace with the actual PHP script URL
                method: 'POST',
                data: { instructor: instructor },
                success: function (data) {
                    // Update the table body with the fetched instructor data
                    $('tbody').html(data);
                },
                error: function () {
                    alert('Error fetching data');
                }
            });
        });

        // Handle changes in the room select element
        $('#room').change(function () {
            // Get the selected room
            var room = $(this).val();

            // Make an AJAX request to fetch room-related data
            $.ajax({
                url: 'View/primary_room.php', // Replace with the actual PHP script URL
                method: 'POST',
                data: { room: room },
                success: function (data) {
                    // Update the table body with the fetched room data
                    $('tbody').html(data);
                },
                error: function () {
                    alert('Error fetching data');
                }
            });
        });
    });
</script>

<script>
    document.getElementById('instructor').addEventListener('change', function() {
        document.getElementById('room').value = '';
    });

    document.getElementById('room').addEventListener('change', function() {
        document.getElementById('instructor').value = '';
    });

</script>

<!-- <script>
        function requestRevision() {
            var requestBtn = document.getElementById("requestRevision");
            var editBtn = document.getElementById("editSchedule");
            var requestDrop = document.getElementById("requestDrop");

            requestBtn.style.display = "none";
            requestDrop.style.display = "none";
            editBtn.style.display = "block";
        }

        function requestDrop() {
            var requestBtn = document.getElementById("requestRevision");
            var requestDrop = document.getElementById("requestDrop");
            var dropSchedule = document.getElementById("dropSchedule");

            requestBtn.style.display = "none";
            requestDrop.style.display = "none";
            dropSchedule.style.display = "block";
        }

</script> -->

<script>
$("#editSchedule").on("click", function() {
    // Get selected values from dropdown
    var instructor = $("#instructor").val();
    var room = $("#room").val();

    if (instructor) {
        // Use SweetAlert for confirmation
        Swal.fire({
            title: "Confirmation",
            text: "Are you sure you want to edit the instructor: " + instructor + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, edit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the appropriate edit page with parameters
                var instructor = $("#instructor").val();
                window.location.href = `edit_primary_instructor_schedule.php?instructor=${instructor}`;
            }
        });
    } else if (room) {
        // Use SweetAlert for confirmation
        Swal.fire({
            title: "Confirmation",
            text: "Are you sure you want to edit the room: " + room + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, edit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var room = $("#room").val();
                // Redirect to the appropriate edit page with parameters
                window.location.href = `edit_primary_room_schedule.php?room=${room}`;
            }
        });
    } else {
        // Debugging statement
        console.log("No instructor or room selected.");
    }
});
</script>

<script>
    function requestRevision() {
        Swal.fire({
            title: 'Confirmation',
            text: 'Are you sure you want to request a revision for the schedule?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, send request!'
        }).then((result) => {
            if (result.isConfirmed) {
                var requestBtn = document.getElementById("requestRevision");
                var editBtn = document.getElementById("editSchedule");
                var requestDrop = document.getElementById("requestDrop");

                requestBtn.style.display = "none";
                requestDrop.style.display = "none";
                editBtn.style.display = "block";
                // editBtn.disabled = true; // Disable the button
            }
        });
    }

    function requestDrop() {
        Swal.fire({
            title: 'Confirmation',
            text: 'Are you sure you want to request to drop the schedule?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, send request!'
        }).then((result) => {
            if (result.isConfirmed) {
                var requestBtn = document.getElementById("requestRevision");
                var requestDrop = document.getElementById("requestDrop");
                var dropSchedule = document.getElementById("dropSchedule");

                requestBtn.style.display = "none";
                requestDrop.style.display = "none";
                dropSchedule.style.display = "block";
                // dropSchedule.disabled = true; // Disable the button
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $("#dropSchedule").on("click", function() {
            // Display SweetAlert confirmation
            Swal.fire({
                title: 'Confirmation?',
                text: 'Are you sure you want to drop the schedule',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, drop it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "DropSchedule/drop_schedule.php",
                        success: function(response) {
                            // Handle success, e.g., show a success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Dropped the schedule successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // Reload the page after a short delay
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        },
                        error: function(error) {
                            // Handle error, e.g., show an error message
                            Swal.fire('Error', 'Failed to drop schedule. Please try again.', 'error');
                            console.error("Error drop schedule:", error);
                        }
                    });
                }
            });
        });        
    });

</script>




</body>

</html>