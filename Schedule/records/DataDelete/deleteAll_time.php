<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('../../config/db_connection.php');

    if (isset($_POST['timeAvailIDs'])) {
        
        $timeAvailIDs = $_POST['timeAvailIDs'];

        // $sqlDelete = "UPDATE instructortimeavailabilities SET Active = 0 WHERE InstructorTimeAvailabilitiesID = ?";
        // $stmtDelete = $conn->prepare($sqlDelete);


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

            $response = array('success' => true, 'message' => 'Instructor Availability Deleted Successfully');
            echo json_encode($response);
            exit();
            
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

                    // $activity = 'Retrieved room number ';
                    $activity = 'Delete Instructor Availability';
                    $currentDateTime = date('Y-m-d H:i:s');
                    $active = 1;

                    $sqlLog = "INSERT INTO logs (DateTime, Activity, UserInfoID, Active, CreatedAt) VALUES (?, ?, ?, ?, NOW())";
                    $stmtLog = $conn->prepare($sqlLog);
                    $stmtLog->bind_param("ssii", $currentDateTime, $activity, $userInfoID, $active);
                    $resultLog = $stmtLog->execute();
                }
            }



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
