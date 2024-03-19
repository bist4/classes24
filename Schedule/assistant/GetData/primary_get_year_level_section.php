<?php
// Include your database connection file here
include('../../config/db_connection.php');

// Check if the 'yearLevel' parameter is set in the POST request
if (isset($_POST['yearLevel'])) {
    // Sanitize the input to prevent SQL injection
    $yearLevel = $_POST['yearLevel'];
    // Use prepared statements to prevent SQL injection
    $query = "SELECT DISTINCT s.SectionID, s.SectionName FROM classsections s
              INNER JOIN departments d ON s.DepartmentID = d.DepartmentID
              WHERE d.DepartmentID = $yearLevel AND s.Active = 1
              AND NOT EXISTS (
                  SELECT 1 FROM classschedules c
                  WHERE c.SectionID = s.SectionID
              ) ";

    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        // Build the HTML options for the 'section' dropdown
        $options = '<option value="" disabled selected>Select Section</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            $options .= '<option value="' . $row['SectionID'] . '">' . $row['SectionName'] . '</option>';
        }
        // Send the HTML options back to the client-side script
        echo $options;
    } else {
        // Handle the error if the query fails
        echo 'Error fetching data';
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Handle the case where 'yearLevel' parameter is not set
    echo 'Invalid request';
}
?>
