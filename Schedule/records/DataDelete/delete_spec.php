<?php
// Retrieve.php

// Check if instructorID is provided
if(isset($_POST['instructorID'])) {
    // Include database connection script
    require('../../config/db_connection.php');
    
    // Sanitize input to prevent SQL injection
    $instructorID = $_POST['instructorID'];

    // Delete the instructor specialization
    $sql = "DELETE FROM instructorspecializations WHERE InstructorSpecializationsID = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('i', $instructorID);
        if ($stmt->execute()) {
            // If deletion is successful, return success response
            $response = array('success' => true);
            echo json_encode($response);
        } else {
            // If deletion fails, return error response
            $response = array('success' => false, 'message' => 'Failed to delete specialization: ' . $conn->error);
            echo json_encode($response);
        }
    } else {
        // If there's an error in preparing the SQL statement, return error response
        $response = array('success' => false, 'message' => 'Error in preparing SQL statement: ' . $conn->error);
        echo json_encode($response);
    }

    // Close database connection
    $conn->close();
} else {
    // If instructorID is not provided, return error response
    $response = array('success' => false, 'message' => 'Instructor ID not provided.');
    echo json_encode($response);
}
?>
