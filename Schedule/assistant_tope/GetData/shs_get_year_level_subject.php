<?php
// Include your database connection file here
include('../../config/db_connection.php');

// Check if the 'yearLevel' parameter is set in the POST request
if (isset($_POST['yearLevel'])) {
    // Sanitize the input to prevent SQL injection
    $yearLevel = $_POST['yearLevel'];

    // Prepare a parameterized query to fetch sections based on the selected year level
    $query = "SELECT s.SubjectDescription FROM subjects s
            INNER JOIN department d ON s.DepartmentID = d.DepartmentID
            WHERE d.YearLevel = ? AND s.Active = 1";

    
    $stmt = mysqli_prepare($conn, $query);

    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "s", $yearLevel);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Check if the query was successful
    if ($result) {
        // Build the HTML options for the 'section' dropdown
        $options = '<option value="" disabled selected>Select Subject</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            $options .= '<option value="' . $row['SubjectDescription'] . '">' . $row['SubjectDescription'] . '</option>';
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
    // Handle the case where 'yearLevel' parameter is not set
    echo 'Invalid request';
}
?>
