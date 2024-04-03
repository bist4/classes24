<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('../../config/db_connection.php');

    if (isset($_POST['timeAvailIDs'])) {
        
        $timeAvailIDs = $_POST['timeAvailIDs'];

        // Prepare and execute the SQL update query for each SectionID
        $updatesql = "UPDATE instructortimeavailabilities SET Active = 0 WHERE InstructorTimeAvailabilitiesID = ?";
        $stmt = $conn->prepare($updatesql);

        if ($stmt) {
            foreach ($timeAvailIDs as $timeAvailID) {
                $stmt->bind_param("i", $timeAvailID);
                $stmt->execute();

                // Check if the update was successful
                if ($stmt->affected_rows <= 0) {
                    $response = array('success' => false, 'message' => 'Failed to deactivate instructor availability.');
                    echo json_encode($response);
                    exit;
                }
            }

            // Add logs activity
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

                    // Fetch Fname and Mname based on InstructorID from the Instructors table
                    $sqlInstructor = "SELECT i.InstructorID, usi.Fname, usi.Mname FROM instructortimeavailabilities ist
                    INNER JOIN instructors i ON ist.InstructorID = i.InstructorID
                    LEFT JOIN userinfo usi ON i.UserInfoID = usi.UserInfoID
                    WHERE ist.InstructorTimeAvailabilitiesID = ?";
                    $stmtInstructor = $conn->prepare($sqlInstructor);
                    $stmtInstructor->bind_param("i", $timeAvailID); // Use $timeAvailID here
                    $stmtInstructor->execute();
                    $resultInstructor = $stmtInstructor->get_result();
                    $instructorData = $resultInstructor->fetch_assoc();
            
                    $Fname = $instructorData['Fname'];
                    $Mname = $instructorData['Mname'];
            
                    // Proceed with logging
                    $activity = 'Delete Instructor Availability: ' . '<br>Instructor: ' . $Fname . ' ' . $Mname;
                    $currentDateTime = date('Y-m-d H:i:s');
                    $active = 1;

                    $sqlLog = "INSERT INTO logs (DateTime, Activity, UserInfoID, Active, CreatedAt) VALUES (?, ?, ?, ?, NOW())";
                    $stmtLog = $conn->prepare($sqlLog);
                    $stmtLog->bind_param("ssii", $currentDateTime, $activity, $userInfoID, $active);
                    $resultLog = $stmtLog->execute();
                    
                    // Check if the insertion into logs was successful
                    if (!$resultLog) {
                        $response = array('success' => false, 'message' => 'Failed to insert log entry.');
                        echo json_encode($response);
                        exit;
                    }
                }
            }

            $response = array('success' => true, 'message' => 'Instructor Availability Deleted Successfully');
            echo json_encode($response);
            exit();
            
        } else {
            $response = array('success' => false, 'message' => 'Error in preparing SQL statement: ' . $conn->error);
            echo json_encode($response);
        }
    } else {
        $response = array('success' => false, 'message' => 'No Instructor Availability IDs provided!');
        echo json_encode($response);
    }
}
?>
