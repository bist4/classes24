<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('../../config/db_connection.php');

    if (isset($_POST['roomIDs'])) {
        $roomIDs = $_POST['roomIDs'];

        $updatesql = "UPDATE rooms SET Active = 0 WHERE RoomID = ?";
        $stmt = $conn->prepare($updatesql);

        if ($stmt) {
            foreach ($roomIDs as $roomID) {
                $stmt->bind_param("i", $roomID);
                $stmt->execute();

                if ($stmt->affected_rows <= 0) {
                    $response = array('success' => false, 'message' => 'Failed to deactivate rooms.');
                    echo json_encode($response);
                    exit;
                }
            }

            $response = array('success' => true, 'message' => 'Room(s) Deleted Successfully');
            echo json_encode($response);
            exit();
        } else {
            $response = array('success' => false, 'message' => 'Error in preparing SQL statement: ' . $conn->error);
            echo json_encode($response);
        }
    } else {
        $response = array('success' => false, 'message' => 'No Room IDs provided!');
        echo json_encode($response);
    }
}
?>
