<?php
require('../../config/db_connection.php');
session_start();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $specializations = isset($_POST['specializations']) ? $_POST['specializations'] : [];
    $instructorSpecializationsIDs = $_POST['InstructorSpecializationsID'];

    // Update instructors table
    foreach ($instructorSpecializationsIDs as $index => $instructorSpecializationID) {
        $instructorSpecializationID = $conn->real_escape_string($instructorSpecializationID); // Escape special characters
        $specialization = $conn->real_escape_string($specializations[$index]); // Get specialization for current ID

        $instructor_sql = "UPDATE instructorspecializations SET SpecializationName = '$specialization' WHERE InstructorSpecializationsID = $instructorSpecializationID";

        if ($conn->query($instructor_sql) !== TRUE) {
            $response['error'] = "Error updating instructor record: " . $conn->error;
            echo json_encode($response);
            $conn->close();
            exit;
        }
    }

    // Log the activity
    if (isset($_SESSION['Username'])) {
        $loggedInUsername = $_SESSION['Username'];
    
        $sqlUserCheck = "SELECT * FROM userinfo WHERE Username=?";
        $stmtUserCheck = $conn->prepare($sqlUserCheck);
        $stmtUserCheck->bind_param("s", $loggedInUsername);
        $stmtUserCheck->execute();
        $resultUserCheck = $stmtUserCheck->get_result();
    
        if ($resultUserCheck && $resultUserCheck->num_rows > 0) {
            $row = $resultUserCheck->fetch_assoc();
            $userInfoID = $row['UserInfoID'];
    
            $currentDateTime = date('Y-m-d H:i:s');
            $activity = "Updated instructor specializations";
            $active = 1;
    
            $sqlLog = "INSERT INTO logs (DateTime, Activity, UserInfoID, Active, CreatedAt) VALUES (?, ?, ?, ?, NOW())";
            $stmtLog = $conn->prepare($sqlLog);
            $stmtLog->bind_param("ssii", $currentDateTime, $activity, $userInfoID, $active);
            $resultLog = $stmtLog->execute();
        }
    }

    // Return success response
    $response['success'] = "Instructor Specialization(s) updated successfully";
    echo json_encode($response);

    // Close connection
    $conn->close();
}
?>
