<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('../../config/db_connection.php'); // Adjust the path to your database connection file

    if (isset($_POST['instructorID'])) {
        $instructorID = $_POST['instructorID'];

        $updatesql = "UPDATE instructors SET Active = 11 WHERE InstructorID = ?";
        $stmt = $conn->prepare($updatesql);

        if ($stmt) {
            foreach ($instructorID as $instructorID) {
                $stmt->bind_param("i", $instructorID);
                $stmt->execute();

                if ($stmt->affected_rows <= 0) {
                    echo json_encode(["errors" => "Failed to deactivate instructors."]);

                    exit; // Stop further processing if any update fails
                }

                
            }

            echo json_encode(["success" => "Instructor Archives successfully"]);
            exit(); 
        } else {
            echo json_encode(["errors" => "Error in preparing SQL statement: " . $conn->error]);
 
        }
    } else {
        echo json_encode(["errors" => "No Instructor IDs provided!"]);

    }
}
?>
