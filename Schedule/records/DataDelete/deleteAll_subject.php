<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('../../config/db_connection.php'); // Adjust the path to your database connection file

    if (isset($_POST['subjectIDs'])) {
        $subjectIDs = $_POST['subjectIDs'];

        // Prepare and execute the SQL update query for each StrandID
        $updatesql = "UPDATE subjects SET Active = 0 WHERE SubjectID = ?";
        $stmt = $conn->prepare($updatesql);

        if ($stmt) {
            foreach ($subjectIDs as $subjectID) {
                $stmt->bind_param("i", $subjectID);
                $stmt->execute();

                if ($stmt->affected_rows <= 0) {
                    $response = array('success' => false, 'message' => 'Failed to deactivate subject(s).');
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
        $response = array('success' => false, 'message' => 'No Subject IDs provided!');
        echo json_encode($response);
    }
}
?>
