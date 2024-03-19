<?php
require('../../config/db_connection.php');

if (isset($_POST['section']) && isset($_POST['yearLevel'])) {
    $yearLevel = $_POST['yearLevel'];
    $section = $_POST['section'];


    $sql = "SELECT 
    sub.SubjectDescription,
    cs.Time_Start, cs.Time_End,
    CONCAT(usi.Fname, ' ', usi.Lname) AS InstructorName,
    r.RoomNumber,
    cs.Monday, cs.Tuesday, cs.Wednesday, cs.Thursday, cs.Friday,
    cs.ClasscheduleID
    FROM classschedule cs
    INNER JOIN department d ON cs.DepartmentID = d.DepartmentID
    INNER JOIN sections s ON cs.SectionID = s.SectionID 

    INNER JOIN subjects sub ON cs.SubjectID = sub.SubjectID
    INNER JOIN userroles usr ON cs.InstructorID = usr.UserRoleID
    INNER JOIN userinfo usi ON usr.UserID = usi.UserInfoID 
    INNER JOIN rooms r ON cs.RoomID = r.RoomID
    WHERE d.DepartmentID = ? AND s.SectionID = ?
    AND cs.Active = 0 ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $yearLevel, $section);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
    $count = 1;

    // Start capturing the output in a variable
    ob_start();

    // Begin capturing the content within the table-responsive div
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>";

    echo "<tbody id='strandTable'>";

    while ($row = $result->fetch_assoc()) {
    // Outputting table rows with fetched data
    echo "<tr>";
    echo "<td><input type='checkbox'  class='checkSingle' name='selectedSchedule[]' id='check_" . $row['ClasscheduleID'] . "' data-id='" . $row['ClasscheduleID'] . "' value='" . $row['ClasscheduleID'] . "'></td>";
    echo "<td>" . $row['SubjectDescription'] . "</td>";

    // Format time start
    $timeStart = date("h:i A", strtotime($row['Time_Start']));
    // Format time end
    $timeEnd = date("h:i A", strtotime($row['Time_End']));
    echo "<td>$timeStart - $timeEnd</td>";

    echo "<td>";
    if ($row['Monday'] == 1) echo "M ";
    if ($row['Tuesday'] == 1) echo "T ";
    if ($row['Wednesday'] == 1) echo "W ";
    if ($row['Thursday'] == 1) echo "TH ";
    if ($row['Friday'] == 1) echo "F ";
    echo "</td>";


    echo "<td>" . $row['InstructorName'] . "</td>";
    echo "<td>" . $row['RoomNumber'] . "</td>";
    echo "</tr>";
    }

    echo "</tbody></table></div>";

    // End capturing the content within the table-responsive div
    $tableContent = ob_get_clean();

    // Send the captured HTML content as a response
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


















