<?php
require('../../config/db_connection.php');

if (isset($_POST['strand']) && isset($_POST['semester']) && isset($_POST['yearLevel'])) {
    $semester = $_POST['semester'];
    $yearLevel = $_POST['yearLevel'];
    $strand = $_POST['strand'];

    // Use prepared statements to prevent SQL injection
    $query = "SELECT DISTINCT Section FROM classschedule 
              WHERE YearLevel = ? 
              AND Active = 0 
              AND Department = 'Senior High School' 
              AND Semester = ? 
              AND Strand = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $yearLevel, $semester, $strand);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check for errors during the database operation
    if (!$result) {
        die("Error in fetching section data: " . $conn->error);
    }

    // Build the HTML options for the "section" dropdown
    $options = '<option value="" disabled selected>Select Section</option>';
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row['Section'] . '">' . $row['Section'] . '</option>';
    }

    // Send the HTML options back to the client-side script
    echo $options;

    // Close the result set and statement
    $result->close();
    $stmt->close();
} else {
    echo '<option disabled selected>Select Strand, Semester, and Year Level first</option>';
}
?>
