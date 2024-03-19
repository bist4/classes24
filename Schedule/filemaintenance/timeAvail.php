<?php
require "../config/db_connection.php";
include "../security.php"; // Start the session

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
    <title>Instructor Availability - File Maintenance</title>
    <style>
        /* Hide the up and down arrow for number input */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>


</head>

<?php include "session_out.php"; ?>

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
            <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>File Maintenance</span>
                </a>
                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="file_strand.php">Strand</a>
                        <a class="collapse-item" href="file_subject.php">Subject</a>
                        <!-- <a class="collapse-item" href="file_instructor.php">Instructor</a> -->
                        <a class="collapse-item" href="file_section.php">Class Section</a>
                        <a class="collapse-item" href="file_room.php">Room</a>
                        <a class="collapse-item active" href="timeAvail.php">Instructor Availability</a>

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
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../utilities/accounts.php">Account Management</a>
                        <a class="collapse-item" href="../utilities/archive.php">Archive</a>
                        <a class="collapse-item" href="../utilities/backup.php">Back Up</a>
                        <a class="collapse-item" href="../utilities/logs.php">Activity History</a>
                        <a class="collapse-item" href="../utilities/trash.php">Trash</a>
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
                        <h1 class="h3 mb-2 text-gray-800">Add New Instructor Availability</h1>
                    </div>

                    <br>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            

                            
                            <div id="myForm">
                                <!-- Form Add Data -->
                                <div class="col-md-6">
                                    <label for="instructor">Instructor</label>
                                    <select class="form-control" id="instructor" name="Instructor[]" required onchange="getInstructors(this.value)">
                                        <option value="" disabled selected>Select Instructor</option>
                                        <!-- Your PHP code to generate instructor options -->
                                        <?php
                                          require "../config/db_connection.php";

                                          $sqlDepartment = "SELECT i.InstructorID, usi.Fname, usi.Mname, usi.Lname FROM instructors i INNER JOIN userinfo usi ON i.UserInfoID = usi.UserInfoID WHERE i.Status = 0";

                                          $resultDepartmentTypeName = $conn->query($sqlDepartment);
                                          
                                          if ($resultDepartmentTypeName->num_rows > 0) {
                                              // Array to keep track of displayed combinations
                                              $displayedCombinations = array();
                                          

                                            while ($row = $resultDepartmentTypeName->fetch_assoc()) {
                                                echo '<option value="' . $row["InstructorID"] . '">' . $row['Fname'] . ' ' . $row['Mname'] . ' ' . $row["Lname"] . '</option>';
                                            }
                                            
                                          }
                                        ?>
                                    </select>
                                </div>  
                                <br>

                                <div class="table-responsive">
                                    <table  class="table table-hover small-text" id="tb">
                                        <tr class="tr-header">
                                            
                                            <th><label class="form-check-label" for="hideDays">Day</label></th> 
                                            <th><label class="form-check-label" for="hideTimeStart">Time Start</label></th>
                                            <th><label class="form-check-label" for="hideTimeEnd">Time End</label></th>
                                            
                                            <th>
                                                <a href="javascript:void(0);" style="font-size:18px;" id="addMore" title="Add More Availability">
                                                <span class="fas fa-plus"></span>
                                                </a>
                                            </th>
                                        <tr>
                                        <td class="col-md-5">
                                            <div class="form-group" id="Day">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input Day form-control" type="checkbox" id="mondayCheckbox" name="Days[]" value="Monday">
                                                    <label class="form-check-label" for="mondayCheckbox">Mon</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input Day form-control" type="checkbox" id="tuesdayCheckbox" name="Days[]" value="Tuesday">
                                                    <label class="form-check-label" for="tuesdayCheckbox">Tue</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input Day form-control" type="checkbox" id="wednesdayCheckbox" name="Days[]" value="Wednesday">
                                                    <label class="form-check-label" for="wednesdayCheckbox">Wed</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input Day form-control" type="checkbox" id="thursdayCheckbox" name="Days[]" value="Thursday">
                                                    <label class="form-check-label" for="thursdayCheckbox">Thu</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input Day form-control" type="checkbox" id="fridayCheckbox" name="Days[]" value="Friday">
                                                    <label class="form-check-label" for="fridayCheckbox">Fri</label>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- <td class="col-md-3">
                                            <input type="time" class="form-control TimeStart" id="TimeStart" name="TimeStart[]" placeholder="Enter TimeStart" min="08:00" max="17:00" required pattern="(?:[01]\d|2[0-3]):(?:[0-5]\d)">
                                        </td>
                                        <td class="col-md-3">
                                            <input type="time" class="form-control TimeEnd" id="TimeEnd" name="TimeEnd[]" placeholder="Enter TimeEnd" min="08:00" max="17:00" required pattern="(?:[01]\d|2[0-3]):(?:[0-5]\d)">
                                        </td> -->

                                        <td class="col-md-3">
                                            <input type="time" class="form-control TimeStart" id="TimeStart" name="TimeStart[]" placeholder="Enter TimeStart" min="08:00" max="17:00" required pattern="(?:[01]\d|2[0-3]):(?:[0-5]\d)">
                                            <span class="warning-start" style="display:none; color:red;">Please enter a time after 8:00 AM.</span>
                                        </td>
                                        <td class="col-md-3">
                                            <input type="time" class="form-control TimeEnd" id="TimeEnd" name="TimeEnd[]" placeholder="Enter TimeEnd" min="08:00" max="17:00" required pattern="(?:[01]\d|2[0-3]):(?:[0-5]\d)">
                                            <span class="warning-end" style="display:none; color:red;">Please enter a time before 5:00 PM.</span>
                                        </td>

                                        <td><a href='javascript:void(0);'  class='remove'><span class='fas fa-minus'></span></a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- Form End -->
                        </div>
                       
                        <!-- End Card Body -->
                    </div> 
                    <div class="text-center" id="btnSave">
                        <button type="submit" id="saveBtn" name="add" class="btn btn-primary btn-save" disabled>Save</button>
                    </div>
                    <!-- End Card -->
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
	<script src="../assets/js/filteringStrand.js"></script>
	<script src="../assets/js/capitalLetter.js"></script>
    <!-- Print and Import to Excel -->
    <script src="../assets/js/DataPrintExcel/print_subject.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

                  
    <script>
        // Selecting the input fields
        const timeStartInput = document.querySelector('.TimeStart');
        const timeEndInput = document.querySelector('.TimeEnd');

        // Adding event listeners for input change
        timeStartInput.addEventListener('change', function () {
            const startTime = this.value;
            if (startTime < '08:00') {
                this.value = '';
                document.querySelector('.warning-start').style.display = 'block';
            } else {
                document.querySelector('.warning-start').style.display = 'none';
            }
        });

        timeEndInput.addEventListener('change', function () {
            const endTime = this.value;
            if (endTime > '17:00' || endTime === '12:00' || endTime === '00:00' || endTime === '01:00' || endTime === '02:00' || endTime === '03:00' || endTime === '04:00' || endTime === '05:00' || endTime === '06:00' || endTime === '07:00' || endTime === '08:00') {
                this.value = '';
                document.querySelector('.warning-end').style.display = 'block';
            } else {
                document.querySelector('.warning-end').style.display = 'none';
            }
        });


       


    </script>
    <!-- Add new rows -->

    <script>
        $(function () {
            $('#addMore').on('click', function (){
                // var instructor = $('#instructor').val().trim();
                var instructor = document.getElementById('instructor').value.trim();
                var checkedCheckboxes = $('input[name="Days[]"]:checked');
                var TimeStart = document.getElementById('TimeStart').value.trim();
                var TimeEnd = document.getElementById('TimeEnd').value.trim();

            

                if (!instructor) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please Select Instructor',
                    });
                }else if(checkedCheckboxes.length === 0){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please Select at least one day',
                    });
                }else if(!TimeStart){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please input Time Start',
                    });
                }else if(!TimeEnd){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please input Time End',
                    });
                }
                else {
                    
                    var newRow = $("#tb tbody tr:last").clone(true);
                    var rowLength = $("#tb tbody tr").length;

                    newRow.find('.TimeStart').attr('id', 'time_start_' + rowLength).val('');
                    newRow.find('.TimeEnd').attr('id', 'time_end_' + rowLength).val('');

                    // Add event listeners to the newly created TimeStart and TimeEnd inputs
                    newRow.find('.TimeStart').on('change', function () {
                        const startTime = this.value;
                        if (startTime < '08:00') {
                            this.value = '';
                            $(this).siblings('.warning-start').css('display', 'block');
                        } else {
                            $(this).siblings('.warning-start').css('display', 'none');
                        }
                    });

                    newRow.find('.TimeEnd').on('change', function () {
                        const endTime = this.value;
                        if (
                            endTime > '17:00' ||
                            ['12:00', '00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00'].includes(endTime)
                        ) {
                            this.value = '';
                            $(this).siblings('.warning-end').css('display', 'block');
                        } else {
                            $(this).siblings('.warning-end').css('display', 'none');
                        }
                    });

                    // Update IDs and labels for the checkboxes in the new row
                    newRow.find('.Day').each(function (index) {
                        var newId = 'day_' + rowLength + '_' + (index + 1);
                        $(this).attr('id', newId).prop('checked', false);
                        $(this).next('label').attr('for', newId);
                    });

                    // Append the modified new row to your table
                    $("#tb tbody").append(newRow);


                }
            });

            $(document).on('click', '.remove', function () {
                var trIndex = $(this).closest("tr").index();
                if (trIndex > 1) {
                    $(this).closest("tr").remove();
                    $('#saveBtn').prop('disabled', false);
                } else {
                    // Use SweetAlert for the error message
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: "Sorry, Can't remove first row",
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function(){
      
            // Function to check if all required fields are filled
            function checkFields() {
                // Check if the instructor, days, TimeStart, and TimeEnd fields have values
                var instructorSelected = $('#instructor').val();
                var daysChecked = $('input[name="Days[]"]:checked').length > 0;
                var timeStartFilled = $('.TimeStart').filter(function() {
                    return $(this).val() !== '';
                }).length > 0;
                var timeEndFilled = $('.TimeEnd').filter(function() {
                    return $(this).val() !== '';
                }).length > 0;

                // Enable the Save button if all fields are filled
                if (instructorSelected !== '' && daysChecked && timeStartFilled && timeEndFilled) {
                    $('#saveBtn').prop('disabled', false);
                } else {
                    $('#saveBtn').prop('disabled', true);
                }
            }

            // Call the function on change or input in any of the fields
            $('#instructor, input[name="Days[]"], .TimeStart, .TimeEnd').on('change input', function() {
                checkFields();
            });

            // Initially disable the Save button
            $('#saveBtn').prop('disabled', true);

        });
    </script>
    
    <!-- Add  -->
    <script>
        var changesMade = false;
    var updateSuccess = false;
        $(document).ready(function(){
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
            $('.btn-save').click(function(e){
                changesMade = false;
                e.preventDefault();

                var formData = {};
                var existingData = {};

                formData['InstructorID'] = $('#instructor').val();

                var timeAvails = [];
                var fieldsFilled = true;


               


                $('input[type="text"], input[type="time"], select').each(function() {
                    if ($(this).val() === '') {
                        fieldsFilled = false; // Set fieldsFilled to false if any field is empty
                        return false; // Exit the loop early
                    }
                });



                if (!fieldsFilled) {
                    // Show warning if any field is empty
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Please fill in all fields.',
                    });
                    return; // Exit the function if fields are not filled
                }
                else{

                    var dayChecked = $('.Day:checked');

                    

                    
                    var startTime = $('#TimeStart').val();
                    var endTime = $('#TimeEnd').val();

                    

                    var start = new Date("2000-01-01 " + startTime); // Using an arbitrary date for comparison
                    var end = new Date("2000-01-01 " + endTime);

                    var startLimit = new Date("2000-01-01 08:00 AM");
                    var endLimit = new Date("2000-01-01 05:00 PM");

                    if (start < startLimit || end > endLimit) {
                        // Show warning if time is outside the allowed range
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: 'Please select a time between 8:00 AM and 5:00 PM.',
                        });
                        return; // Exit the function if the time is not within the allowed range
                    } 
                   
                    else{

                       

                        $("#tb tr:not(:first)").each(function (index) {
                            var availability = {
                                Day: $(this).find(".Day:checked").map(function () {
                                    return $(this).val();
                                }).get().join(), 
                                // TimeStart: $('#TimeStart').val(),
                                // TimeEnd: $('#TimeEnd').val()
                                TimeStart: $(this).find(".TimeStart").val(),
                                TimeEnd: $(this).find(".TimeEnd").val()
                                
                            };
                            

                            
                            var checkedDays = {}; // Object to store checked days

                            $('.Day:checked').each(function () {
                                var checkedDay = $(this).val();

                                if (checkedDays[checkedDay]) {
                                    var rowNumber = index;
                                    // If the day is already in the object, display a warning message
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Warning',
                                        text: checkedDay + ' was already checked in row ' + rowNumber
                                    });
                                    fieldsFilled = false; // Set to false to prevent further processing
                                    return false; 
                                } else {
                                    // If the day is not in the object, add it to the object
                                    checkedDays[checkedDay] = true;
                                }
                            });

                            if(availability.TimeStart == availability.TimeEnd){
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Warning',
                                    text: 'Time start and Time end should not be equal. Please select a time between 8:00 AM and 5:00 PM.'
                                });
                                fieldsFilled = false; // Set to false to prevent further processing
                                return false; 
                            }
                            

                            if(availability.TimeStart >= availability.TimeEnd){
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Warning',
                                    text: 'Time is not correct. Please select a time between 8:00 AM and 5:00 PM.'
                                });
                                fieldsFilled = false; // Set to false to prevent further processing
                                return false; 
                            }
                             
                         
                            var sameData = availability.Day + '_' + availability.TimeStart + '_' + availability.TimeEnd;
                            if (existingData[sameData]) {
                                var rowNumber = index + 1; // Adding 1 to match the row number visible to users
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Warning',
                                    text: 'Instructor availability Day ' + availability.Day + ' with time start ' + availability.TimeStart + ' and time end ' + availability.TimeEnd + ' already exists in row ' + rowNumber
                                });
                                fieldsFilled = false; // Set to false to prevent further processing
                                return false; 
                            }

                            
                            existingData[sameData] = true;
                            timeAvails.push(availability);
                            
                        });

                        formData['TimeAvail'] = timeAvails;
                        // console.log(formData);
                    
                    

                        if (!fieldsFilled) {
                            return; // Stop further execution if any field is empty
                        }

                        $.ajax({
                            type: 'POST',
                            url: 'DataAdd/add_time.php',
                            data: formData,
                            success: function(response) {
                                // Handle success response
                                response = JSON.parse(response);
                                if (response.success) {
                                    // Show success message
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.success,
                                    }).then(function() {
                                        window.location.href = 'timeAvail.php';
                                    });
                                } else if (response.error) {
                                    // Show warning message in case of an error
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Warning',
                                        text: response.error,
                                    });
                                }
                            },
                            error: function() {
                                // Show error message for AJAX failure
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An error occurred while retrieving data.',
                                }).then(function() {
                                    window.location.href = 'timeAvail.php';
                                });
                            }
                        });
                    }
                }
                
            });
        });

    </script>



</body>

</html>


