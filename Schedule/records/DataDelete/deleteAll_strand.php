<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('../../config/db_connection.php'); // Adjust the path to your database connection file

    if (isset($_POST['strandIDs'])) {
        $strandIDs = $_POST['strandIDs'];

        // Prepare and execute the SQL update query for each StrandID
        $updatesql = "UPDATE strands SET Active = 0 WHERE StrandID = ?";
        $stmt = $conn->prepare($updatesql);

        if ($stmt) {
            foreach ($strandIDs as $strandID) {
                $stmt->bind_param("i", $strandID);
                $stmt->execute();

                // Check if the update was successful
                if ($stmt->affected_rows <= 0) {
                    $response = array('success' => false, 'message' => 'Failed to deactivate strand(s).');
                    echo json_encode($response);
                    exit;
                }
                 
            }

            $response = array('success' => true, 'message' => 'Strand(s) Deleted Successfully');
            echo json_encode($response);
            exit();
        } else {
            $response = array('success' => false, 'message' => 'Error in preparing SQL statement: ' . $conn->error);
            echo json_encode($response);
        }
    } else {
        $response = array('success' => false, 'message' => 'No Strand IDs provided!');
        echo json_encode($response);
    }
}
?>