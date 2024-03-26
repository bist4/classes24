<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('../../config/db_connection.php'); // Adjust the path to your database connection file

    if (isset($_POST['sectionIDs'])) {
        $sectionIDs = $_POST['sectionIDs'];

        // Prepare and execute the SQL update query for each SectionID
        $updatesql = "UPDATE classsections SET Active = 0 WHERE SectionID = ?";
        $stmt = $conn->prepare($updatesql);

        if ($stmt) {
            foreach ($sectionIDs as $sectionID) {
                $stmt->bind_param("i", $sectionID);
                $stmt->execute();

                if ($stmt->affected_rows <= 0) {
                    $response = array('success' => false, 'message' => 'Failed to deactivate section(s).');
                    echo json_encode($response);
                    exit;
                }
            }

            $response = array('success' => true, 'message' => 'Section(s) Deleted Successfully');
            echo json_encode($response);
            exit();
        } else {
            $response = array('success' => false, 'message' => 'Error in preparing SQL statement: ' . $conn->error);
            echo json_encode($response);
        }
    } else {
        $response = array('success' => false, 'message' => 'No Section IDs provided!');
        echo json_encode($response);
    }
}
?>
                 