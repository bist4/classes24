<?php
require '../../config/db_connection.php';

session_start();

// Initialize response array
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['StrandID'])) {
        $strandID = $_POST['StrandID'];

        // Check if the Strand with the given ID exists and if it's active
        $stmtCheckStrand = $conn->prepare("SELECT StrandCode, Active FROM strands WHERE StrandID = ?");
        $stmtCheckStrand->bind_param("i", $strandID);
        $stmtCheckStrand->execute();
        $resultCheckStrand = $stmtCheckStrand->get_result();

        if ($resultCheckStrand->num_rows === 1) {
            $row = $resultCheckStrand->fetch_assoc();
            $strandName = $row['StrandCode'];
            $isActive = $row['Active'];

            if ($isActive == 1) {
                $response['error'] = "The data already exists and is active";
            } else {
                // Data doesn't exist in filemantanance, proceed with restoration
                $sqlUpdateActive = "UPDATE strands SET Active = 1 WHERE StrandID = ?";
                $stmtUpdateActive = $conn->prepare($sqlUpdateActive);
                $stmtUpdateActive->bind_param("i", $strandID);

                if ($stmtUpdateActive->execute()) {
                    $departmentTypeNameID = 1;
                    $yearLevels = [11, 11, 12, 12];
                    $semesters = [1, 2, 1, 2];

                    $insertDepartmentSql = "INSERT INTO departments (DepartmentTypeNameID, GradeLevel, Semester, StrandID) VALUES (?, ?, ?, ?)";
                    $stmtInsertDepartment = $conn->prepare($insertDepartmentSql);

                    for ($i = 0; $i < count($yearLevels); $i++) {
                        $stmtInsertDepartment->bind_param(
                            "iiii",
                            $departmentTypeNameID,
                            $yearLevels[$i],
                            $semesters[$i],
                            $strandID
                        );
                        if ($stmtInsertDepartment->execute()) {
                            // Log activity
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

                                    $activity = 'Restored strand name ' . $strandName;
                                    $currentDateTime = date('Y-m-d H:i:s');
                                    $active = 1;

                                    $sqlLog = "INSERT INTO logs (DateTime, Activity, UserInfoID, Active, CreatedAt) VALUES (?, ?, ?, ?, NOW())";
                                    $stmtLog = $conn->prepare($sqlLog);
                                    $stmtLog->bind_param("ssii", $currentDateTime, $activity, $userInfoID, $active);
                                    $resultLog = $stmtLog->execute();
                                }
                            }
                        } else {
                            $response['error'] = "Failed to restore strand";
                            break; // Break the loop if an error occurs
                        }
                    }
                    $response['success'] = "Strand restored successfully";
                    $stmtInsertDepartment->close();
                } else {
                    $response['error'] = "Failed to update strand status";
                }
            }
        } else {
            $response['error'] = "Strand not found or invalid ID";
        }

        // Close the prepared statements
        $stmtCheckStrand->close();
    } else {
        $response['error'] = "Invalid input";
    }
} else {
    $response['error'] = "Invalid request";
}

// Send JSON response
echo json_encode($response);
?>
