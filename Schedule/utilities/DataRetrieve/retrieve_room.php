<?php
require('../../config/db_connection.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['RoomID'])) {
        $roomID = $_POST['RoomID'];

        // Check if RoomNumber already exists in the rooms table
        $stmtCheckRoomNumber = $conn->prepare("SELECT RoomNumber, Active FROM rooms WHERE RoomID = ?");
        $stmtCheckRoomNumber->bind_param("i", $roomID);
        $stmtCheckRoomNumber->execute();
        $resultCheckRoomNumber = $stmtCheckRoomNumber->get_result();

        if ($resultCheckRoomNumber->num_rows === 1) {
            $row = $resultCheckRoomNumber->fetch_assoc();
            $roomNumber = $row['RoomNumber'];
            $isActive = $row['Active'];

            // Check if the RoomNumber exists and is active
            if ($isActive == 1) {
                echo json_encode(["error" => "The data already exists and is active"]); 
            } else {
                // Check if another record with the same RoomNumber is active
                $stmtCheckActiveRoom = $conn->prepare("SELECT RoomID FROM rooms WHERE RoomNumber = ? AND Active = 1");
                $stmtCheckActiveRoom->bind_param("s", $roomNumber);
                $stmtCheckActiveRoom->execute();
                $resultCheckActiveRoom = $stmtCheckActiveRoom->get_result();

                if ($resultCheckActiveRoom->num_rows > 0) {
                    echo json_encode(["error" => "The data are already in File Maintenance."]);  
                } else {
                    // Update the Active status in the rooms table
                    $sqlUpdateActive = "UPDATE rooms SET Active = 1 WHERE RoomID = ?";
                    $stmtUpdateActive = $conn->prepare($sqlUpdateActive);
                    $stmtUpdateActive->bind_param("i", $roomID);

                    if ($stmtUpdateActive->execute()) {
                        echo json_encode(["success" => "Room restored successfully"]);

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
                                $activity = 'Restored room number ' . $roomNumber;
                                $currentDateTime = date('Y-m-d H:i:s');
                                $active = 1;

                                $sqlLog = "INSERT INTO logs (DateTime, Activity, UserInfoID, Active, CreatedAt) VALUES (?, ?, ?, ?, NOW())";
                                $stmtLog = $conn->prepare($sqlLog);
                                $stmtLog->bind_param("ssii", $currentDateTime, $activity, $userInfoID, $active);
                                $resultLog = $stmtLog->execute();
                            }
                        }
                    } else {
                        echo json_encode(["error" => "Error restoring room: " . $conn->error]);
                    }

                    // Close the prepared statement
                    $stmtUpdateActive->close();
                }
            }
        } else {
            echo json_encode(["success" => "Error: Room does not exist" . $conn->error]);
        }

        // Close the prepared statements
        $stmtCheckRoomNumber->close();
        $stmtCheckActiveRoom->close();
    } 
} else {
    echo json_encode(["error" => "Invalid Request"]);

}
?>
