<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('../../config/db_connection.php');

    if (isset($_POST['subjectIDs'])) {
        $subjectIDs = $_POST['subjectIDs'];

        // Check if any of the subjectIDs are associated with class schedules
        $query = "SELECT COUNT(*) AS count FROM classschedules WHERE SubjectID IN (" . implode(',', array_fill(0, count($subjectIDs), '?')) . ")";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind parameters
            foreach ($subjectIDs as $key => $subjectID) {
                $stmt->bind_param('i', $subjectIDs[$key]);
            }
            
            // Execute the statement
            $stmt->execute();
            
            // Fetch the result
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            // Check if any class schedules exist for the Subject
            if ($row['count'] > 0) {
                $response = array('success' => false, 'message' => 'The Subject is already scheduled.');
                echo json_encode($response);
                exit;
            }
            
            // Proceed with deactivating the Subject
            $updatesql = "UPDATE subjects SET Active = 0 WHERE SubjectID = ?";
            $stmt = $conn->prepare($updatesql);

            if ($stmt) {
                foreach ($subjectIDs as $subjectID) {
                    $stmt->bind_param("i", $subjectID);
                    $stmt->execute();

                    if ($stmt->affected_rows <= 0) {
                        $response = array('success' => false, 'message' => 'Failed to deactivate Subject.');
                        echo json_encode($response);
                        exit;
                    }
                }

                $response = array('success' => true, 'message' => 'Subject(s) Deleted Successfully');
                echo json_encode($response);
                exit();
            } else {
                $response = array('success' => false, 'message' => 'Error in preparing SQL statement: ' . $conn->error);
                echo json_encode($response);
            }
        } else {
            $response = array('success' => false, 'message' => 'Error in preparing SQL statement: ' . $conn->error);
            echo json_encode($response);
        }
    } else {
        $response = array('success' => false, 'message' => 'No Subject IDs provided!');
        echo json_encode($response);
    }
}
?>