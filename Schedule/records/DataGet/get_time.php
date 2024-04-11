<link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="../../assets/js/demo/datatables-demo.js"></script>

<?php
require "../../config/db_connection.php";

if (isset($_POST['instructorID'])) {
    $instructorID = $_POST['instructorID'];

    $sql = "SELECT InstructorTimeAvailabilitiesID, is_Monday, is_Tuesday, is_Wednesday, is_Thursday, is_Friday, Time_Start, Time_End, InstructorID FROM instructortimeavailabilities WHERE InstructorID = ? AND Active = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $instructorID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $count = 1;

        // Start capturing the output in a variable
        ob_start();

        // Begin capturing the content within the table-responsive div
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>";
        echo "<thead><tr>
            <th scope='col'>#</th>
            <th scope='col'>Days</th>
            <th scope='col'>Time</th>
            <th scope='col'>Action</th>
              </tr></thead>";
        echo "<tbody id='timeTable'>";

        $mergedRows = [];

        while ($row = $result->fetch_assoc()) {
            $key = $row['Time_Start'] . $row['Time_End'];

            if (!isset($mergedRows[$key])) {
                $mergedRows[$key] = [];
            }

            $mergedRows[$key][] = $row;
        }

        $count = 1;
        foreach ($mergedRows as $mergedRow) {
            $startTime = date("g:ia", strtotime($mergedRow[0]['Time_Start']));
            $endTime = date("g:ia", strtotime($mergedRow[0]['Time_End']));

            $days = [];
            foreach ($mergedRow as $row) {
                foreach (['is_Monday', 'is_Tuesday', 'is_Wednesday', 'is_Thursday', 'is_Friday'] as $day) {
                    if ($row[$day] == 1) {
                        $days[] = substr($day, 3);
                    }
                }
            }
            $uniqueDays = implode(", ", array_unique($days));

            echo "<tr>";
            echo "<td rowspan='" . count($mergedRow) . "'><div class='form-check form-check-inline'>
                <input class='form-check-input checkSingle' type='checkbox' name='selectedSection[]' id='check_" . $mergedRow[0]['InstructorTimeAvailabilitiesID'] . "' data-id='" . $mergedRow[0]['InstructorTimeAvailabilitiesID'] . "' value='" . $mergedRow[0]['InstructorTimeAvailabilitiesID'] . "'>
            </div></td>";

            // Start modification: Separate days and time for the first row
            echo "<td rowspan='" . count($mergedRow) . "'>" . implode(", ", array_unique($days)) . "</td>";
            echo "<td rowspan='" . count($mergedRow) . "'>" . $startTime . " - " . $endTime . "</td>";

            foreach ($mergedRow as $key => $row) {
                if ($key !== 0) {
                    echo "<tr>";
                }

                // Start modification: Ensure buttons are only displayed in the first row
                if ($key === 0) {
                    echo "<td rowspan='" . count($mergedRow) . "'>";
                    echo "<div class='d-flex justify-content-center'>";
                    // echo "<a href='EditData/edit_time.php?subid=" . $row['InstructorTimeAvailabilitiesID'] . "'>
                    //     <button class='btn btn-primary mr-3' title='Edit Availability'><i class='fa fa-edit'></i></button>
                    // </a>";
                    // echo "<a href='DeleteData/delete_time.php?delid=" . $row['InstructorTimeAvailabilitiesID'] . "'>
                    //     <button class='btn btn-danger' title='Delete Availability'><i class='fa fa-trash'></i></button>
                    // </a>";
                    if (count($mergedRow) > 1) {
                        // If there are multiple IDs, create a URL with all IDs concatenated
                        $editIDs = "";
                        $deleteIDs = "";
                        foreach ($mergedRow as $row) {
                            $editIDs .= $row['InstructorTimeAvailabilitiesID'] . ",";
                            $deleteIDs .= $row['InstructorTimeAvailabilitiesID'] . ",";
                        }
                        $editIDs = rtrim($editIDs, ",");
                        $deleteIDs = rtrim($deleteIDs, ",");
                        echo "<a href='EditData/edit_time.php?subid=" . $editIDs . "'>
                            <button class='btn btn-primary mr-3' title='Edit Availability'><i class='fa fa-edit'></i></button>
                        </a>";
                        echo "<a href='DeleteData/delete_time.php?delid=" . $deleteIDs . "'>
                            <button class='btn btn-danger' title='Delete Availability'><i class='fa fa-trash'></i></button>
                        </a>";
                    } else {
                        // If there's only one ID, display single edit and delete buttons
                        echo "<a href='EditData/edit_time.php?subid=" . $mergedRow[0]['InstructorTimeAvailabilitiesID'] . "'>
                            <button class='btn btn-primary mr-3' title='Edit Availability'><i class='fa fa-edit'></i></button>
                        </a>";
                        echo "<a href='DeleteData/delete_time.php?delid=" . $mergedRow[0]['InstructorTimeAvailabilitiesID'] . "'>
                            <button class='btn btn-danger' title='Delete Availability'><i class='fa fa-trash'></i></button>
                        </a>";
                    }
                    echo "</div>";
                    echo "</td>";
                }
                // End modification

                

                if ($key !== 0) {
                    echo "</tr>";
                }
            }
            echo "</tr>";
            $count++;
        }

        // End capturing the content within the table-responsive div
        echo "</tbody></table></div>";

        // Send the captured HTML content as a response
        $tableContent = ob_get_clean();
        echo $tableContent;
    } else {
        // If no data is found in the table
        echo "<div class='table-responsive'><table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'><tbody>";
        echo "<tr><td colspan='5'>No data available</td></tr>";
        echo "</tbody></table></div>";
    }

    $stmt->close();
} else {
    // Invalid request
    echo "Invalid request";
}
?>
