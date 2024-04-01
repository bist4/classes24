<?php
// Retrieve.php

// Check if instructorID is provided
if(isset($_POST['instructorID'])) {
    // Include database connection script
    require('../../config/db_connection.php');
    
    // Sanitize input to prevent SQL injection
    $instructorID = $_POST['instructorID'];

    // Check if the instructor exists in class schedules
    $sqlCheck = "SELECT COUNT(*) AS count FROM classschedules WHERE InstructorID = ?";
    $stmtCheck = $conn->prepare($sqlCheck);

    if ($stmtCheck) {
        $stmtCheck->bind_param('i', $instructorID);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        $rowCheck = $resultCheck->fetch_assoc();

        if ($rowCheck['count'] > 0) {
            // If the instructor exists in class schedules, return error response
            $response = array('success' => false, 'message' => 'Instructor cannot be retrieved as they are associated with class schedules.');
            echo json_encode($response);
            exit();
        }
    } else {
        // If there's an error in preparing the SQL statement, return error response
        $response = array('success' => false, 'message' => 'Error in preparing SQL statement: ' . $conn->error);
        echo json_encode($response);
        exit();
    }

    // Update the Active status of the instructor to 1
    $sql = "UPDATE instructors SET Active = 0 WHERE InstructorID = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('i', $instructorID);
        if ($stmt->execute()) {
            // If update is successful, return success response
            $response = array('success' => true);
            echo json_encode($response);
        } else {
            // If update fails, return error response
            $response = array('success' => false, 'message' => 'Failed to retrieve instructor: ' . $conn->error);
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
