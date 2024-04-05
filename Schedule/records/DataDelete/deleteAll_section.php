<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('../../config/db_connection.php');

    if (isset($_POST['sectionIDs'])) {
        $sectionIDs = $_POST['sectionIDs'];

        // Check if any of the sectionIDs are associated with class schedules
        $query = "SELECT COUNT(*) AS count FROM classschedules WHERE SectionID IN (" . implode(',', array_fill(0, count($sectionIDs), '?')) . ")";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind parameters
            foreach ($sectionIDs as $key => $sectionID) {
                $stmt->bind_param('i', $sectionIDs[$key]);
            }
            
            // Execute the statement
            $stmt->execute();
            
            // Fetch the result
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            // Check if any class schedules exist for the section
            if ($row['count'] > 0) {
                $response = array('success' => false, 'message' => 'The section is already scheduled.');
                echo json_encode($response);
                exit;
            }
            
            // Proceed with deactivating the section
            $updatesql = "UPDATE classsections SET Active = 0 WHERE SectionID = ?";
            $stmt = $conn->prepare($updatesql);

            if ($stmt) {
                foreach ($sectionIDs as $sectionID) {
                    $stmt->bind_param("i", $sectionID);
                    $stmt->execute();

                    if ($stmt->affected_rows <= 0) {
                        $response = array('success' => false, 'message' => 'Failed to deactivate section.');
                        echo json_encode($response);
                        exit;
                    }
                }

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

                        foreach ($sectionIDs as $sectionID) {
                            $sqlStrandInfo = "SELECT * FROM classsections WHERE SectionID=?";
                            $stmtStrandInfo = $conn->prepare($sqlStrandInfo);
                            $stmtStrandInfo->bind_param("i", $sectionID);
                            $stmtStrandInfo->execute();
                            $resultStrandInfo = $stmtStrandInfo->get_result();

                            if ($resultStrandInfo && $resultStrandInfo->num_rows > 0) {
                                $strandRow = $resultStrandInfo->fetch_assoc();
                                $StrandCode = $strandRow['SectionNo'];
                                $StrandName = $strandRow['SectionName'];

                                $sqlLog = "INSERT INTO logs (DateTime, Activity, UserInfoID, Active, CreatedAt) VALUES (NOW(), ?, ?, ?, NOW())";
                                $stmtLog = $conn->prepare($sqlLog);
                                $activity = 'Delete Class Section ' . $StrandCode . ' ' . $StrandName;
                                $active = 1;
                                $stmtLog->bind_param("sii", $activity, $userInfoID, $active);
                                $resultLog = $stmtLog->execute();
                                if (!$resultLog) {
                                    $response = array('success' => false, 'message' => 'Failed to insert deletion log.');
                                    echo json_encode($response);
                                    exit;
                                }
                            } else {
                                $response = array('success' => false, 'message' => 'Failed to fetch class section information for log insertion.');
                                echo json_encode($response);
                                exit;
                            }
                        }
                    } else {
                        $response = array('success' => false, 'message' => 'Failed to get user information for log insertion.');
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response = array('success' => false, 'message' => 'User not logged in.');
                    echo json_encode($response);
                    exit;
                }
                

                $response = array('success' => true, 'message' => 'Section(s) Deleted Successfully');
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
        $response = array('success' => false, 'message' => 'No Section IDs provided!');
        echo json_encode($response);
    }
}
?>