<?php
require('../../config/db_connection.php');
include('../../security.php');// Start the session

// Check if the user is logged in
// Check if the user is logged in
if (isset($_SESSION['Username'])) {
    $loggedInName = $_SESSION['Username'];

    $query = "SELECT is_Lock_Account, UserTypeID FROM userinfo WHERE Username = '$loggedInName' AND UserTypeID = 2";
    // Execute the query
    $result = $conn->query($query);

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
    if (isset($_GET['subid']) && !empty($_GET['subid'])) {
        // Get the classsections IDs from the URL
        $sectionIDs = explode(',', $_GET['subid']);
        $allSectionData = array(); // Initialize an array to store all section data
    
        // Prepare the SQL statement to fetch data for multiple SubjectIDs
        $placeholders = str_repeat('?,', count($sectionIDs) - 1) . '?';
        $subsql = "SELECT * FROM classsections WHERE SectionID IN ($placeholders)";
        $stmt = mysqli_prepare($conn, $subsql);
    
        // Bind parameters for each SectionID
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
                echo "No section found for the provided IDs";
            }
        } else {
            echo "Error executing the query: " . mysqli_error($conn);
        }
    
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "No section ID provided!";
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
    
    <link rel="icon" href="../../assets/img/logo1.png">
     <!-- Style for icons and fonts -->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
    <link href="../../assets/css/select2.min.css" rel="stylesheet">
    
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css" integrity="sha512-0nkKORjFgcyxv3HbE4rzFUlENUMNqic/EzDIeYCgsKa/nwqr2B91Vu/tNAu4Q0cBuG4Xe/D1f/freEci/7GDRA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link href="chosen.css" rel="stylesheet">

    <title>Edit Section - File Maintenance</title>



    <style>
        /* Custom CSS for hover effect */
        .card-body h6 {
            display: inline-block;
            margin-right: 20px; /* Adjust spacing between titles */
            
            position: relative;
            color: #000; /* Adjust text color */
            text-decoration: none; /* Remove default underline */
            transition: color 0.3s ease; /* Smooth color transition */
        }

        .card-body h6.active {
            /* Additional style for the active class */
            color: #f47339; /* Adjust text color */
            transition: color 0.3s ease; /* Smooth color transition */
        }
        .card-body h6.active::after {
            width: 100%;
            background: #f47339; /* Adjust underline color on active */
            transition: width 0.3s ease; /* Smooth width transition */
        } 
        .card-body h6::after {
            content: '';
            display: block;
            width: 0;
            height: 3px; /* Adjust underline thickness */
            background: #f47339; /* Adjust underline color */
            position: absolute;
            bottom: -5px; /* Adjust the distance from the text */
            transition: width 0.3s ease; /* Smooth width transition */
        }

        .card-body h6:hover::after {
            width: 100%;
        }

        .card-body h6:hover {
            color: #f47339; /* Adjust text color on hover */
        }

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

<?php
include('session_out.php');
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../../system_admin.php">
                <div class="sidebar-brand-icon">
                    <i class="fas">
                        <img src="../../assets/img/logo1.png" alt="logo" width="50" height="50">
                    </i>
                </div>
                <div class="sidebar-brand-text mx-3" style="font-size: 13px">Online Class Scheduling System</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../../system_admin.php">
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
                            <a class="collapse-item" href="../../filemaintenance/file_strand.php">Strand</a>
                            <a class="collapse-item" href="../../filemaintenance/file_subject.php">Subject</a>
                            <!-- <a class="collapse-item" href="../../filemaintenance/file_instructor.php">Instructor</a> -->
                            <a class="collapse-item" href="../../filemaintenance/file_section.php">Class Section</a>
                            <a class="collapse-item" href="../../filemaintenance/file_room.php">Room</a>
                            <a class="collapse-item" href="../../filemaintenance/timeAvail.php">Instructor Availability</a>
                            
                        </div>
                    </div>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseView"
                        aria-expanded="true" aria-controls="collapseView">
                        <i class="fas fa-fw fa-eye"></i>
                        <span>View Records</span>
                    </a>
                    <div id="collapseView" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="view_strand.php">Strand</a>
                            <a class="collapse-item" href="../view_subject.php">Subject</a>
                            <a class="collapse-item" href="../view_instructor.php">Instructor</a>
                            <a class="collapse-item active" href="../view_section.php">Class Section</a>
                            <a class="collapse-item" href="../view_room.php">Room</a>
                            <a class="collapse-item" href="../view_timeAvail.php">Instructor Availability</a>

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
                            
                            <a class="collapse-item" href="../../utilities/accounts.php">Account Management</a>
                            <a class="collapse-item" href="../../utilities/archive.php">Archive</a>
                            <!-- <a class="collapse-item" href="../utilities/backup.php">Back Up</a> -->
                            <a class="collapse-item" href="../../utilities/logs.php">Activity History</a>
                            <a class="collapse-item" href="../../utilities/trash.php">Trash</a>

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

                   
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Alerts -->
                        

                        

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                <!-- <img class="img-profile rounded-circle"
                                    src="../../img/undraw_profile.svg"> -->
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
                        <h1 class="h3 mb-2 text-gray-800">Section</h1>
                         
                    </div>
                    

                  
                    
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h6 class="d-inline-block active" id="viewStrand">Edit Section</h6>
                             
                        </div>
                    
                        <div class="card-body">
                            <div class="" id="addContainer">
                            <form id="updateForm">
                                <div class="table-responsive">
                                    <table class="table table-hover small-text" id="tb">
                                        <tr class="tr-header">
                                            <th><label class="form-check-label" for="hideSectionNo">Section Number</label></th>
                                            <th><label class="form-check-label" for="hideSectionName">Section Name</label></th>                                            
                                        </tr>
                                        <?php foreach ($allSectionData as $secdata) { ?>
                                            <tr>
                                                <td class="col-md-2">
                                                    <input type="text" pattern="\d{2}"  maxlength="2" class="form-control" id="SectionNo" value="<?php echo $secdata['SectionNo']; ?>" name="SectionNo[]" placeholder="Enter Section Number" title="Input Section Number" oninput="this.value.replace(/[^0-9]/g, '').slice(0, 2)">
                                                </td>
                                                <td class="col-md-4">
                                                    <input type="text" class="form-control" id="SectionName" value="<?php echo $secdata['SectionName']; ?>" name="SectionName[]" placeholder="Enter Section Name" title="Input Section Name">
                                                    <input type="hidden" name="SectionID[]" value="<?php echo $secdata['SectionID']; ?>">

                                                </td>
                                                
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="button" id="cancelBtn" class="btn btn-outline-secondary mr-2" onclick="goBack()">Cancel</button>
                                    <button type="button" id="updateBtn" class="btn btn-primary">Update</button>
                                </div>
                            </form>

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

                    <form action="../../logout.php" method="POST">
                        <button type="submit"  name="logout_btn" class="btn btn-primary">Logout</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    
 
 
    
    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../assets/js/demo/datatables-demo.js"></script>
    <!-- For filtering of section details -->
	<script src="../../assets/js/filteringStrand.js"></script>


 
    <!-- Print and Import to Excel -->
    <script src="../../assets/js/DataPrintExcel/print_subject.js"></script>
    <script src="../../assets/js/capitalLetter.js"></script>
 
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
 

    <script>
    var changesMade = false;
    var updateSuccess = false;
    $(document).ready(function () {
        function setChangesMade() {
            changesMade = true;
        }

        // Bind change event to form elements
        $(".form-control").change(setChangesMade);
        $("textarea").change(setChangesMade); // Listen for changes in textareas as well

        // Bind beforeunload event to show confirmation message
        window.addEventListener('beforeunload', function(e) {
            if (changesMade && !updateSuccess) {
                var confirmationMessage = "Changes you made may not be saved. Are you sure you want to leave?";
                (e || window.event).returnValue = confirmationMessage;
                return confirmationMessage;
            }
        });

        $('#updateBtn').on('click', function (e) {
            e.preventDefault(); // Prevent form submission by default

            changesMade = false;
            var formData = $('#updateForm').serialize(); // Serialize the form data
            var error = false; // Declare error variable

            var fields = document.querySelectorAll("#updateForm input, #updateForm textarea");
            fields.forEach(function(field) {
                var trimmedValue = field.value.trim();
                if (trimmedValue === "") {
                    error = true;
                    field.classList.add("is-invalid");
                } else if (/^\s/.test(field.value)) {
                    error = true;
                    field.classList.add("is-invalid");
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Spaces before letters are not allowed.',
                    });
                } else {
                    field.classList.remove("is-invalid");
                }
            });

            if (error) {
                return false; // Prevent form submission if there are errors
            }
            
            $.ajax({
                type: 'POST',
                url: '../DataUpdate/update_section.php',
                data: formData,
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.success) {
                        Swal.fire({
                            title: "Success!",
                            text: response.success,
                            icon: "success",
                        }).then(function () {
                            updateSuccess = true; // Set updateSuccess to true upon successful update
                            window.location.href = '../view_section.php';
                        });
                    } else if (response.error) {
                        Swal.fire({
                            title: "Warning!",
                            text: response.error,
                            icon: "warning",
                        });
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to update section information!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

 
<script>
    function goBack() {
    // Navigate back in history
    history.go(-1);

    // Reset the department selection
    document.getElementById('department').value = '';
}

</script>

<script>
    $(document).ready(function () {
        // Function to create and show validation message
        function showValidationMessage(inputField, message) {
            // Check if validation message element exists, if not, create it
            var validationMessageId = inputField.id + "_validation_message";
            var validationMessageElement = document.getElementById(validationMessageId);
            if (!validationMessageElement) {
                validationMessageElement = document.createElement("div");
                validationMessageElement.id = validationMessageId;
                validationMessageElement.classList.add("invalid-feedback");
                inputField.parentNode.appendChild(validationMessageElement);
            }
            // Update validation message text and display it
            validationMessageElement.innerText = message;
            inputField.classList.add("is-invalid");
        }

        // Function to hide validation message
        function hideValidationMessage(inputField) {
            var validationMessageId = inputField.id + "_validation_message";
            var validationMessageElement = document.getElementById(validationMessageId);
            if (validationMessageElement) {
                validationMessageElement.innerText = "";
                inputField.classList.remove("is-invalid");
            }
        }

        function validateFormFields() {
    var fields = document.querySelectorAll("input");
    var hasErrors = false; // Flag to track if there are any validation errors
    fields.forEach(function(field) {
        var trimmedValue = field.value.trim();
        if (field.id === "SectionNo" && !/^\d*$/.test(trimmedValue)) {
            showValidationMessage(field, 'Section Number must contain only numbers.');
            hasErrors = true; // Set flag to true if there is an error
        } else if ((field.id === "SectionName" || field.id === "subDesc") && !trimmedValue) {
            showValidationMessage(field, 'This field cannot be empty.');
            hasErrors = true; // Set flag to true if there is an error
        } else if ((field.id === "subDesc" || field.id === "SubjectCode") && !/^[a-zA-Z]*$/.test(trimmedValue)) {
            showValidationMessage(field, 'Only letters are allowed.');
            hasErrors = true; // Set flag to true if there is an error
        } else if (field.id === "SubjectCode" && /^\s/.test(field.value)) {
            showValidationMessage(field, 'Spaces before letters are not allowed.');
            hasErrors = true; // Set flag to true if there is an error
        } else if (field.id !== "SectionNo" && /^\s/.test(field.value)) {
            showValidationMessage(field, 'Spaces before letters are not allowed.');
            hasErrors = true; // Set flag to true if there is an error
        } else {
            hideValidationMessage(field);
        }
    });

    // If errors were found, disable the update button
    if (hasErrors) {
        $('#updateBtn').prop('disabled', true);
    } else {
        $('#updateBtn').prop('disabled', false);
    }
}



        // Event listener for input fields to validate while typing
        $("input").on("input", function() {
            validateFormFields();
        });

       

        
    });
</script>

 
    
</body>

</html>
