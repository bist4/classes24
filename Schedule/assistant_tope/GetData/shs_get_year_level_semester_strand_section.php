<?php
// Include your database connection file here
include('../../config/db_connection.php');

// Check if both 'semester', 'yearLevel', and 'strand' parameters are set in the POST request
if (isset($_POST['semester']) && isset($_POST['yearLevel']) && isset($_POST['strand'])) {
    // Sanitize the input to prevent SQL injection
    $yearLevel = $_POST['yearLevel'];
    $semester = $_POST['semester'];
    $strand = $_POST['strand'];

    // Prepare a parameterized query to fetch sections based on the selected year level, semester, and strand
    $query = "SELECT s.SectionName FROM sections s
            INNER JOIN department d ON s.DepartmentID = d.DepartmentID
            INNER JOIN strands st ON d.StrandID = st.StrandID
            WHERE d.YearLevel = ? AND d.Semester = ? AND st.StrandName = ? AND s.Active = 1
            AND NOT EXISTS (
                SELECT 1 FROM classschedule cs
                WHERE cs.Section = s.SectionName
            )";

    $stmt = mysqli_prepare($conn, $query);

    // Bind the parameters assuming 'YearLevel' and 'Semester' are integers, and 'StrandName' is a string
    mysqli_stmt_bind_param($stmt, "iss", $yearLevel, $semester, $strand);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Check if the query was successful
    if ($result) {
        // Build the HTML options for the 'subject' dropdown
        $options = '<option value="" disabled selected>Select Section</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            $options .= '<option value="' . $row['SectionName'] . '">' . $row['SectionName'] . '</option>';
        }
        // Send the HTML options back to the client-side script
        echo $options;
    } else {
        // Handle the error if the query fails
        echo 'Error fetching data';
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Close the database connection
    mysqli_close($conn);
} else {
    // Handle the case where 'semester', 'yearLevel', or 'strand' parameters are not set
    echo 'Invalid request';
}
?>
