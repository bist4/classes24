<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('../../config/db_connection.php');

    if (isset($_POST['strandIDs'])) {
        $strandIDs = $_POST['strandIDs'];

        // Check if any of the strandIDs are associated with class schedules
        $query = "SELECT COUNT(*) AS count FROM classschedules WHERE StrandID IN (" . implode(',', array_fill(0, count($strandIDs), '?')) . ")";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind parameters
            foreach ($strandIDs as $key => $strandID) {
                $stmt->bind_param('i', $strandIDs[$key]);
            }
            
            // Execute the statement
            $stmt->execute();
            
            // Fetch the result
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            // Check if any class schedules exist for the strand
            if ($row['count'] > 0) {
                $response = array('success' => false, 'message' => 'The strand is already scheduled.');
                echo json_encode($response);
                exit;
            }
            
            // Proceed with deactivating the strand
            $updatesql = "UPDATE strands SET Active = 0 WHERE StrandID = ?";
            $stmt = $conn->prepare($updatesql);

            if ($stmt) {
                foreach ($strandIDs as $strandID) {
                    $stmt->bind_param("i", $strandID);
                    $stmt->execute();

                    if ($stmt->affected_rows <= 0) {
                        $response = array('success' => false, 'message' => 'Failed to deactivate strand.');
                        echo json_encode($response);
                        exit;
                    }
                }

                // Delete records from departments table based on strandIDs
                $deletesql = "DELETE FROM departments WHERE StrandID IN (" . implode(',', array_fill(0, count($strandIDs), '?')) . ")";
                $stmt = $conn->prepare($deletesql);

                if ($stmt) {
                    foreach ($strandIDs as $key => $strandID) {
                        $stmt->bind_param('i', $strandIDs[$key]);
                        $stmt->execute();
                    }
                } else {
                    $response = array('success' => false, 'message' => 'Error in preparing SQL statement for department deletion: ' . $conn->error);
                    echo json_encode($response);
                    exit;
                }

                $response = array('success' => true, 'message' => 'Strand(s) Deactivated and Departments Deleted Successfully');
                echo json_encode($response);
                exit();
            } else {
                $response = array('success' => false, 'message' => 'Error in preparing SQL statement for strand deactivation: ' . $conn->error);
                echo json_encode($response);
            }
        } else {
            $response = array('success' => false, 'message' => 'Error in preparing SQL statement for class schedule check: ' . $conn->error);
            echo json_encode($response);
        }
    } else {
        $response = array('success' => false, 'message' => 'No strand IDs provided!');
        echo json_encode($response);
    }
}
?>
