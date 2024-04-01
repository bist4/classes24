<?php
require('../../config/db_connection.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['SectionID'])) {
        $sectionID = $_POST['SectionID'];

        // Check if the Section with the given ID exists and if it's active
        $stmtCheckSection = $conn->prepare("SELECT SectionName, Active FROM classsections WHERE SectionID = ?");
        $stmtCheckSection->bind_param("i", $sectionID);
        $stmtCheckSection->execute();
        $resultCheckSection = $stmtCheckSection->get_result();

        if ($resultCheckSection->num_rows === 1) {
            $row = $resultCheckSection->fetch_assoc();
            $sectionName = $row['SectionName'];
            $isActive = $row['Active'];

            // Check if the SectionName exists and is active
            if ($isActive == 1) {
                echo json_encode(["error" => "The data already exists and is active"]);
            } else {
                // Check if another record with the same SectionName is active
                $stmtCheckActiveSection = $conn->prepare("SELECT SectionID FROM classsections WHERE SectionName = ? AND Active = 1");
                $stmtCheckActiveSection->bind_param("s", $sectionName);
                $stmtCheckActiveSection->execute();
                $resultCheckActiveSection = $stmtCheckActiveSection->get_result();

                if ($resultCheckActiveSection->num_rows > 0) {
                    echo json_encode(["error" => "The data are already in File Maintenance."]);
                } else {
                    // Update the Active status in the classsections table
                    $sqlUpdateActive = "UPDATE classsections SET Active = 1 WHERE SectionID = ?";
                    $stmtUpdateActive = $conn->prepare($sqlUpdateActive);
                    $stmtUpdateActive->bind_param("i", $sectionID);

                    if ($stmtUpdateActive->execute()) {
                        // Update was successful
                        echo json_encode(["success" => "Section restored successfully"]);
                        
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
                                $activity = 'Retrieved section name ' . $sectionName;
                                $currentDateTime = date('Y-m-d H:i:s');
                                $active = 1;

                                $sqlLog = "INSERT INTO logs (DateTime, Activity, UserInfoID, Active, CreatedAt) VALUES (?, ?, ?, ?, NOW())";
                                $stmtLog = $conn->prepare($sqlLog);
                                $stmtLog->bind_param("ssii", $currentDateTime, $activity, $userInfoID, $active);
                                $resultLog = $stmtLog->execute();
                            }
                        }
                    } else {
                        // Update failed
                        echo json_encode(["error" => "Error restoring section: " . $conn->error]);
                    }

                    // Close the prepared statement
                    $stmtUpdateActive->close();
                }
            }
        } else {
            echo json_encode(["error" => "Error: Section does not exist"]);
        }
        // Close the prepared statements
        $stmtCheckSection->close();
        $stmtCheckActiveSection->close();
    }
} else {
    echo json_encode(["error" => "Invalid Request"]);
}
?>