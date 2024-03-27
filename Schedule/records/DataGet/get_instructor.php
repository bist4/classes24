<link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="../assets/js/demo/datatables-demo.js"></script>

<?php
require "../../config/db_connection.php";

if (isset($_POST['departmentID'])) {
    $departmentID = $_POST['departmentID'];

    $sql = "SELECT i.*, usi.*, isp.SpecializationName, isp.InstructorSpecializationsID
        FROM instructors i
        INNER JOIN userinfo usi ON i.UserInfoID = usi.UserInfoID
        LEFT JOIN instructorspecializations isp ON isp.InstructorID = i.InstructorID
        
        WHERE i.is_$departmentID = 1 AND i.Active = 1";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $userDetails = [];

        while ($row = $result->fetch_assoc()) {
            $key = $row['Fname'] . '_' . $row['Mname'] . '_' . $row['Lname'] . '_' . $row['Email'];

            if (!isset($userDetails[$key])) {
                $userDetails[$key] = [
                    'Fname' => $row['Fname'],
                    'Mname' => $row['Mname'],
                    'Lname' => $row['Lname'],
                    'Gender' => $row['Gender'],
                    'Age' => $row['Age'],
                    'Birthday' => $row['Birthday'],
                    'Address' => $row['Address'],
                    'ContactNumber' => $row['ContactNumber'],
                    'Email' => $row['Email'],
                    'Status' => $row['Status'],
                    'SpecializationName' => [],
                    'UserInfoID' => $row['UserInfoID'],
                    'InstructorID' => $row['InstructorID'],

                ];
            }
            if (!empty($row['SpecializationName'])) {
                $userDetails[$key]['SpecializationName'][] = $row['SpecializationName'];
            }
        }
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>";
        echo "<thead><tr>
                <th scope='col'>#</th>
                <th scope='col'>Room Number</th>
                <th scope='col'>Capacity</th>
                <th scope='col'>Room Type</th>
                <th scope='col'>Action</th>
              </tr></thead>";
        echo "<tbody id='strandTable'>";

        foreach ($userDetails as $user) {

            

            echo "<tr>";
            echo "<td>" . $user['Fname'] . ' ' . $user['Mname'] . ' ' . $user['Lname'] . "</td>";
            echo "<td>" . (!empty($user['SpecializationName']) ? implode(', ', $user['SpecializationName']) : 'N/A') . "</td>";
            echo "<td>" . ($user['Status'] == 1 ? 'Full Time' : 'Part Time') . "</td>";
            echo "<td>";
            echo  "<div class='d-flex justify-content-center'>";
            echo "<button class='btn btn-info' data-toggle='modal' data-target='#exampleModal' title='View'>
                
           
                <i class='fas fa-eye'></i>
                </button>";
        
            echo "<button class='btn btn-success archive-btn' title='Archive'
                        data-user-id='" . $user['InstructorID'] . "'>
                    <i class='fas fa-archive'></i>
                </button>";
            echo "</div>";
            echo "</td>";
            echo "<td>
                    <div class='dropdown'>
                        <button title='Edit' class='btn btn-primary mr-3 dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></button>
                        <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";
            
            // Check if instructor has specializations
            if (!empty($user['SpecializationName'])) {
                echo "<a class='dropdown-item' href='EditData/edit_specializations.php?subid=" . $user['InstructorID'] . "'>Edit Specializations</a>";
            } else {
                echo "<a class='dropdown-item' href='AddData/add_specialization.php?subid=" . $user['InstructorID'] . "'>Add Specialization</a>";
            }
            
            echo "<a class='dropdown-item' href='EditData/edit_instructor.php?subid=" . $user['InstructorID'] . "'>Edit Status</a>
                            </div>
                        </div>
                    </td>";
            echo "</tr>";
        }
        echo "</tbody></table></div>";
        
    } else {
        echo "<div class='table-responsive'><table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'><tbody>";
        echo "<tr><td colspan='5'>No data available</td></tr>";
        echo "</tbody></table></div>";
    }

    $result->close();
} else {
    echo "Invalid request";
}
?>

 
<!-- ARCHIVE DATA -->

<script>
$(document).ready(function() {
    $('.archive-btn').click(function() {
        var instructorID = $(this).data('user-id');
        
        console.log(instructorID);

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to archive this instructor?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, archive it!'
            }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, proceed with archiving
                $.ajax({
                    type: 'POST',
                    url: 'DataDelete/deleteAll_instructor.php', // Update with your server-side script
                    data: { instructorID: instructorID },
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.success) {
                            Swal.fire({
                                title: "Success!",
                                text: response.success,
                                icon: "success",
                            }).then(function () {
                                updateSuccess = true; // Set updateSuccess to true upon successful update
                                window.location.href = 'view_instructor.php';
                            });
                        } else if (response.error) {
                            Swal.fire({
                                title: "Warning!",
                                text: response.error,
                                icon: "warning",
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'An error occurred while archiving the instructor.',
                            'error'
                        );
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
});
</script>



<!-- View Information Modal -->
<div class="modal fade" id="exampleModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Information will be displayed here -->
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.btn-info').click(function() {
            var fname = $(this).data('fname');
            var mname = $(this).data('mname');
            var lname = $(this).data('lname');
            var birthdate = $(this).data('birthdate');
            var cnumber = $(this).data('cnumber');
            var address = $(this).data('address');
            var gender = $(this).data('gender');
            var email = $(this).data('email');
            var status = $(this).data('status');

            // Construct HTML with the information
            var content = '<label style="font-size:1.5em;">Personal Information</label>' +
                '<p>First Name: ' + fname + '</p>' +
                '<p>Middle Name: ' + mname + '</p>' +
                '<p>Last Name: ' + lname + '</p>' +
                '<p>Birthday: ' + birthdate + '</p>' +
                '<p>Gender: ' + gender + '</p>' +
                '<label style="font-size:1.5em;">Contact Information</label>' +
                '<p>Contact Number: ' + cnumber + '</p>' +
                '<p>Address: ' + address + '</p>' +
                '<p>Email: ' + email + '</p>' +
                '<label style="font-size:1.5em;">Other Information</label>' +
                '<p>Status: ' + (status == 1 ? 'Full Time' : 'Part Time') + '</p>';

            // Insert the HTML into the modal body
            $('#modalBody').html(content);
        });
    });
</script>

 