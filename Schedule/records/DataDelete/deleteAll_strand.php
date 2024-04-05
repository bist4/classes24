<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('../../config/db_connection.php');

    if (isset($_POST['strandIDs'])) {
        $strandIDs = $_POST['strandIDs'];

        // Check if any of the strandIDs are associated with class schedules
        $query = "SELECT COUNT(*) AS count FROM departments WHERE StrandID IN (" . implode(',', array_fill(0, count($strandIDs), '?')) . ")";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind parameters
            $types = str_repeat('i', count($strandIDs));
            $stmt->bind_param($types, ...$strandIDs);

            // Execute the statement
            $stmt->execute();

            // Fetch the result
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            // Check if any class schedules exist for the strand
            if ($row['count'] > 0) {
                // Check if there are corresponding class schedules in the classschedules table
                $classScheduleQuery = "SELECT COUNT(*) AS count FROM classschedules WHERE DepartmentID IN (SELECT DepartmentID FROM departments WHERE StrandID IN (" . implode(',', array_fill(0, count($strandIDs), '?')) . "))";
                $classStmt = $conn->prepare($classScheduleQuery);

                if ($classStmt) {
                    // Bind parameters
                    $classStmt->bind_param($types, ...$strandIDs);

                    // Execute the statement
                    $classStmt->execute();

                    // Fetch the result
                    $classResult = $classStmt->get_result();
                    $classRow = $classResult->fetch_assoc();

                    if ($classRow['count'] > 0) {
                        $response = array('success' => false, 'message' => 'The strand is already scheduled.');
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response = array('success' => false, 'message' => 'Error in preparing SQL statement for class schedule check: ' . $conn->error);
                    echo json_encode($response);
                    exit;
                }
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

                        foreach ($strandIDs as $strandID) {
                            $sqlStrandInfo = "SELECT * FROM strands WHERE StrandID=?";
                            $stmtStrandInfo = $conn->prepare($sqlStrandInfo);
                            $stmtStrandInfo->bind_param("i", $strandID);
                            $stmtStrandInfo->execute();
                            $resultStrandInfo = $stmtStrandInfo->get_result();

                            if ($resultStrandInfo && $resultStrandInfo->num_rows > 0) {
                                $strandRow = $resultStrandInfo->fetch_assoc();
                                $StrandCode = $strandRow['StrandCode'];
                                $StrandName = $strandRow['StrandName'];

                                $sqlLog = "INSERT INTO logs (DateTime, Activity, UserInfoID, Active, CreatedAt) VALUES (NOW(), ?, ?, ?, NOW())";
                                $stmtLog = $conn->prepare($sqlLog);
                                $activity = 'Delete Strand ' . $StrandCode . ' ' . $StrandName;
                                $active = 1;
                                $stmtLog->bind_param("sii", $activity, $userInfoID, $active);
                                $resultLog = $stmtLog->execute();
                                if (!$resultLog) {
                                    $response = array('success' => false, 'message' => 'Failed to insert deletion log.');
                                    echo json_encode($response);
                                    exit;
                                }
                            } else {
                                $response = array('success' => false, 'message' => 'Failed to fetch strand information for log insertion.');
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

                // Delete records from departments table based on strandIDs
                $deletesql = "DELETE FROM departments WHERE StrandID IN (" . implode(',', array_fill(0, count($strandIDs), '?')) . ")";
                $stmt = $conn->prepare($deletesql);

                if ($stmt) {
                    $stmt->bind_param($types, ...$strandIDs);
                    $stmt->execute();
                } else {
                    $response = array('success' => false, 'message' => 'Error in preparing SQL statement for department deletion: ' . $conn->error);
                    echo json_encode($response);
                    exit;
                }

                $response = array('success' => true, 'message' => 'Strand(s) Deleted Successfully');
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
