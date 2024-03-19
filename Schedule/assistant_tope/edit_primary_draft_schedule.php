<?php
require('../config/db_connection.php');
include('../security.php');// Start the session

// Check if the user is logged in
if (isset($_SESSION['Username'])) {
    $loggedInName = $_SESSION['Username'];

    // Make sure you have a valid database connection here

    // Create an SQL query to get the RoleID and UserID of the logged-in user
    $query = "SELECT * FROM users WHERE Username = '$loggedInName'";

    // Execute the query
    $result = $conn->query($query);
    
    if ($result) {
        $row = $result->fetch_assoc();

        // Close the result set
        $result->close();

        if ($row['RoleID'] == 3) {
            // User has RoleID 4 (instructor), so they have access
            // Continue with the page's content
            
            // Display the User ID of the instructor
            // echo "You are an instructor with User ID: " . $row['UserID'];
        } else {
            // User does not have RoleID 4, so they don't have access
            // You can redirect them to an error page or display an error message
            header("location: ../../index.php");
            // Optionally, you can include a link to log out and return to the login page
        }
    } else {
        // Handle the case where the query fails
        echo "Error in fetching RoleID and UserID: " . $conn->error;
    }

    if (isset($_GET['subid']) && !empty($_GET['subid'])) {
        // Get the rooms IDs from the URL
        $sectionIDs = explode(',', $_GET['subid']);
        $allSectionData = array(); // Initialize an array to store all section data
    
        // Prepare the SQL statement to fetch data for multiple SubjectIDs
        $placeholders = str_repeat('?,', count($sectionIDs) - 1) . '?';
        $subsql = "SELECT * FROM classschedule cs
       
        
        WHERE cs.ClasscheduleID IN ($placeholders)";
        $stmt = mysqli_prepare($conn, $subsql);
    
        // Bind parameters for each RoomID
        $types = str_repeat('i', count($sectionIDs)); // 'i' represents integer type
        mysqli_stmt_bind_param($stmt, $types, ...$sectionIDs);
    
        // Execute the statement
        mysqli_stmt_execute($stmt);
    
        // Get the result
        $resultsection = mysqli_stmt_get_result($stmt);
    
        if ($resultsection) {
            // Fetch all data for the specified SubjectIDs
            while ($secdata = mysqli_fetch_assoc($resultsection)) {
                $allSectionData[] = $secdata;
            }
            if (empty($allSectionData)) {
                echo "No Schedule found for the provided IDs";
            }
        } else {
            echo "Error executing the query: " . mysqli_error($conn);
        }
    
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "No schedule ID provided!";
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

    <title>Edit Primary Draft Schedule</title>

    <!-- Favicon and Styles -->
    <link rel="icon" href="../assets/img/logo1.png">
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    </head>

    <?php
    include('session_out.php');
    ?>

    <body id="page-top">


        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../school_director.php">
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
                    <a class="nav-link" href="../school_director.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Create Schedule Section -->
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
                <li class="nav-item active">
                    <a class="nav-link collapsed" href="#"  data-toggle="collapse" data-target="#collapseDraft"
                        aria-expanded="true" aria-controls="collapseDraft">
                        <i class="fas fa-edit"></i>
                        <span>Draft Schedule</span>
                    </a>
                    <div id="collapseDraft" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="shs_draft_schedule.php">Senior High School</a>
                            <a class="collapse-item" href="jhs_draft_schedule.php">Junior High School</a>
                            <a class="collapse-item active" href="primary_draft_schedule.php">Primary</a>
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
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOfficial"
                        aria-expanded="true" aria-controls="collapseOfficial">
                        <i class="fas fa-fw fa-calendar-alt"></i>
                        <span>Modify Schedule</span>
                    </a>
                    <div id="collapseOfficial" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="shs_schedule.php">Senior High School</a>
                            <a class="collapse-item" href="jhs_schedule.php">Junior High School</a>
                            <a class="collapse-item" href="primary_schedule.php">Primary</a>
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

                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">

                            <!-- Alerts Dropdown -->
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell fa-fw"></i>
                                    <span class="badge badge-danger badge-counter">3+</span>
                                </a>
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="alertsDropdown">
                                    <h6 class="dropdown-header">
                                        Alerts Center
                                    </h6>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <!-- ... (Alerts Content) ... -->
                                    </a>
                                    <!-- Add more alerts items as needed -->
                                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                                </div>
                            </li>

                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- User Information Dropdown -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Assistant</span>
                                    <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                                </a>
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
                        <!-- Your page content goes here -->
                        <div class="container mt-4 mb-4">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 ">
                                    <h1 style="font-size: 25px;">Edit Schedule</h1>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Any content you want to add here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <form id="updateForm">
                                <?php
                                            require('../config/db_connection.php');
                                            // Your PHP code to fetch and display data from the database
                                            ?>
                                <div class="table-responsive">
                                        <table class="table table-hover small-text" id="tb">
                                            <thead class="tr-header">
                                                <tr>
                                                    <th>Subject</th>
                                                    <th>Time Start</th>
                                                    <th>Time End</th>   
                                                    <th>Day</th>
                                                    <th>Instructor</th>
                                                    <th>Room</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($allSectionData as $row) { ?>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" class="ClasscheduleID" value="<?php echo $row['ClasscheduleID']; ?>">
                                                            <select class="form-control Subject" id="subject<?php echo $row['ClasscheduleID']; ?>" name="Subject[]" required>
                                                            <?php
                                                                // SQL query to retrieve active subjects
                                                                $sql = "SELECT SubjectDescription, SubjectID FROM subjects WHERE Active = 1";
                                                                // Execute the query
                                                                $result = mysqli_query($conn, $sql);
                                                                // Check if the query was successful
                                                                if ($result) {
                                                                    // Fetch associative array
                                                                    while ($subject = mysqli_fetch_assoc($result)) {
                                                                        // Output an option for each subject
                                                                        echo "<option value='" . $subject['SubjectID'] . "'";
                                                                        // Check if the subject is selected for this class schedule
                                                                        if ($subject['SubjectID'] == $row['SubjectID']) {
                                                                            echo ' selected';
                                                                        }
                                                                        echo ">" . $subject['SubjectDescription'] . "</option>";
                                                                    }
                                                                } else {
                                                                    // Query was not successful, handle the error
                                                                    echo "<option value=''>Error retrieving subjects</option>";
                                                                }
                                                            ?>
                                                        </select>


                                                        </td>
                                                        <td>
                                                            <input type="time" class="form-control Time_Start" id="Time_Start<?php echo $row['ClasscheduleID']; ?>"  name="Time_Start[]" min="08:00" max="17:00" required value="<?php echo $row['Time_Start']; ?>">

                                                        </td>
                                                        <td>
                                                            <input type="time" class="form-control Time_End" id="Time_End<?php echo $row['ClasscheduleID']; ?>" name="Time_End[]" min="08:00" max="17:00" required value="<?php echo $row['Time_End']; ?>">
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input Day" type="checkbox" id="Monday<?php echo $row['ClasscheduleID']; ?>" name="Day[]" value="M" <?php echo ($row['Monday'] == 1) ? 'checked' : ''; ?>>

                                                                <label class="form-check-label" for="Monday">M</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input Day" type="checkbox" id="Tuesday<?php echo $row['ClasscheduleID']; ?>" name="Day[]" value="T" <?php echo ($row['Tuesday'] == 1) ? 'checked' : ''; ?>>
                                                                <label class="form-check-label" for="Tuesday">T</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input Day" type="checkbox" id="Wednesday<?php echo $row['ClasscheduleID']; ?>" name="Day[]"  value="W" <?php echo ($row['Wednesday'] == 1) ? 'checked' : ''; ?>>
                                                                <label class="form-check-label" for="Wednesday">W</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input Day" type="checkbox" id="Thursday<?php echo $row['ClasscheduleID']; ?>" name="Day[]"  value="TH" <?php echo ($row['Thursday'] == 1) ? 'checked' : ''; ?>>
                                                                <label class="form-check-label" for="Thursday">Th</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input Day" type="checkbox" id="Friday<?php echo $row['ClasscheduleID']; ?>" name="Day[]" value="F" <?php echo ($row['Friday'] == 1) ? 'checked' : ''; ?>>
                                                                <label class="form-check-label" for="Friday">F</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                        <select class="form-control Instructor" id="instructor<?php echo $row['ClasscheduleID']; ?>" name="Instructor[]" required>
        <?php
        // SQL query to retrieve active instructors
        $sql = "SELECT CONCAT(Fname, ' ', Lname) AS InstructorName, UserRoleID
                FROM userroles 
                INNER JOIN userinfo ON userroles.UserID = userinfo.UserInfoID 
                WHERE userroles.RoleID = 4";
        
        // Execute the query
        $result = mysqli_query($conn, $sql);
        
        // Check if the query was successful
        if ($result) {
            // Fetch associative array
            while ($instructor = mysqli_fetch_assoc($result)) {
                // Output an option for each instructor
                echo "<option value='" . $instructor['UserRoleID'] . "'";
                // Check if the instructor is selected for this class schedule
                if ($instructor['UserRoleID'] == $row['InstructorID']) {
                    echo ' selected';
                }
                echo ">" . $instructor['InstructorName'] . "</option>";
            }
        } else {
            // Query was not successful, handle the error
            echo "<option value=''>Error retrieving instructors</option>";
        }
        ?>
    </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control Room" id="room<?php echo $secdata['ClasscheduleID']; ?>" name="Room[]" required>
                                                                <!-- <option value="" disabled selected>Select Room</option> -->
                                                                <?php
                                                                // SQL query to retrieve active rooms
                                                                    $sql = "SELECT RoomNumber, RoomID FROM rooms WHERE Active = 1 AND DepartmentID = 3";
                                                                    // Execute the query
                                                                    $result = mysqli_query($conn, $sql);
                                                                    // Check if the query was successful
                                                                    if ($result) {
                                                                        // Fetch associative array
                                                                        while ($room = mysqli_fetch_assoc($result)) {
                                                                            // Output an option for each room
                                                                            echo "<option value='" . $room['RoomID'] . "'";
                                                                            // Check if the room is selected for this class schedule
                                                                            if ($room['RoomID'] == $row['RoomID']) {
                                                                                echo ' selected';
                                                                            }
                                                                            echo ">" . $room['RoomNumber'] . "</option>";
                                                                        }
                                                                    } else {
                                                                        // Query was not successful, handle the error
                                                                        echo "<option value=''>Error retrieving rooms</option>";
                                                                    }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <!-- <td><a href='javascript:void(0);' id="removeRow"><span class='fas fa-minus remove'></span></a></td> -->
                                                    </tr>

                                                    
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" id="cancelBtn" onclick="location.href='primary_draft_schedule.php';" class="btn btn-outline-secondary mr-2">Cancel</button> 
                                            <button type="button" id="updateBtn" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>

                                </form>

                                <div class="card-body">
                                    <!-- Additional content goes here -->
                                </div>
                            </div>
                        </div>

                    </div>

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

        <!-- Logout Modal -->
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
                            <button type="submit" name="logout_btn" class="btn btn-primary">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- JavaScript Section -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../assets/js/sb-admin-2.min.js"></script>
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/js/demo/datatables-demo.js"></script>
    <script src="../assets/js/filteringStrand.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
    var changesMade = false;
    var updateSuccess = false;

    $(document).ready(function () {
        // Function to set changesMade flag
        function setChangesMade() {
            changesMade = true;
        }

        // Bind change event to form elements
        $(".form-control").change(setChangesMade);

        // Bind beforeunload event to show confirmation message
        window.addEventListener('beforeunload', function(e) {
            if (changesMade && !updateSuccess) {
                var confirmationMessage = "Changes you made may not be saved. Are you sure you want to leave?";
                (e || window.event).returnValue = confirmationMessage;
                return confirmationMessage;
            }
        });

        // Bind click event to update button
        $("#updateBtn").on("click", function () {
            // Reset changesMade flag
            changesMade = false;

            // Gather selected values from the form
            var classScheduleData = [];

            // Loop through each row in the table
            $("tbody tr").each(function () {
                var rowData = {
                    ClasscheduleID: $(this).find(".ClasscheduleID").val(),
                    Room: $(this).find(".Room").val(),
                    Instructor: $(this).find(".Instructor").val(),
                    Subject: $(this).find(".Subject").val(), // Include SubjectID
                    TimeStart: $(this).find(".Time_Start").val(), // Include SubjectID
                    TimeEnd: $(this).find(".Time_End").val(), // Include SubjectID
                    Day: $(this).find(".Day:checked").map(function () {
                        return $(this).val();
                    }).get().join(','),
                };

                classScheduleData.push(rowData);
            });

            // If confirmed, perform the AJAX request
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to update?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'DataUpdate/update_primary_schedule.php',
                        type: 'POST',
                        data: {
                            classScheduleData: classScheduleData
                        },
                        success: function (response) {
                            console.log(response);
                            // Handle the success response after update
                            updateSuccess = true;
                            Swal.fire({
                                title: 'Success',
                                text: 'Update successfully!',
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'primary_draft_schedule.php';
                                    // You can perform further actions after the user clicks "OK"
                                }
                            });
                        },
                        error: function (xhr, status, error) {
                            // Handle any errors that occur during the AJAX request
                            console.error(error);
                            // You can display an error message or handle the error accordingly
                        }
                    });
                }
            });
        });
    });
</script>


</body>
</html>