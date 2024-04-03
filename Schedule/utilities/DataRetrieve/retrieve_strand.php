<?php
require('../../config/db_connection.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['StrandID'])) {
        $strandID = $_POST['StrandID'];

        // Check if the Strand with the given ID exists and if it's active
        $stmtCheckStrand = $conn->prepare("SELECT StrandName, Active FROM strands WHERE StrandID = ?");
        $stmtCheckStrand->bind_param("i", $strandID);
        $stmtCheckStrand->execute();
        $resultCheckStrand = $stmtCheckStrand->get_result();

        if ($resultCheckStrand->num_rows === 1) {
            $row = $resultCheckStrand->fetch_assoc();
            $strandName = $row['StrandName'];
            $isActive = $row['Active'];

            if ($isActive == 1) {
                echo json_encode(["error" => "The data already exists and is active"]); 
            } else {

                $sqlUpdateActive = "UPDATE strands SET Active = 1 WHERE StrandID = ?";
                $stmtUpdateActive = $conn->prepare($sqlUpdateActive);
                $stmtUpdateActive->bind_param("i", $strandID);

                if ($stmtUpdateActive->execute()) {
                    $insertDepartmentSql = "INSERT INTO departments (DepartmentTypeNameID, GradeLevel, Semester, StrandID) VALUES (?, ?, ?, ?)";
                    $stmtInsertDepartment = $conn->prepare($insertDepartmentSql);

                    // Bind parameters and execute for GradeLevel 11 and Semester 1
                    $departmentTypeNameID = 1; // Assuming a default value for DepartmentTypeNameID
                    $gradeLevel = 11;
                    $semester = 1;
                    $stmtInsertDepartment->bind_param("iiii", $departmentTypeNameID, $gradeLevel, $semester, $strandID);
                    $stmtInsertDepartment->execute();

                    // Bind parameters and execute for GradeLevel 11 and Semester 2
                    $semester = 2;
                    $stmtInsertDepartment->bind_param("iiii", $departmentTypeNameID, $gradeLevel, $semester, $strandID);
                    $stmtInsertDepartment->execute();

                    // Bind parameters and execute for GradeLevel 12 and Semester 1
                    $gradeLevel = 12;
                    $semester = 1;
                    $stmtInsertDepartment->bind_param("iiii", $departmentTypeNameID, $gradeLevel, $semester, $strandID);
                    $stmtInsertDepartment->execute();

                    // Bind parameters and execute for GradeLevel 12 and Semester 2
                    $semester = 2;
                    $stmtInsertDepartment->bind_param("iiii", $departmentTypeNameID, $gradeLevel, $semester, $strandID);
                    $stmtInsertDepartment->execute();

                    // Check if all inserts were successful
                    if ($stmtInsertDepartment->affected_rows == 4) {
                        // Insertion was successful
                        echo json_encode(["success" => "Strand restored successfully"]);

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

                                $activity = 'Retrieved strand name ' . $strandName;
                                $currentDateTime = date('Y-m-d H:i:s');
                                $active = 1;

                                $sqlLog = "INSERT INTO logs (DateTime, Activity, UserInfoID, Active, CreatedAt) VALUES (?, ?, ?, ?, NOW())";
                                $stmtLog = $conn->prepare($sqlLog);
                                $stmtLog->bind_param("ssii", $currentDateTime, $activity, $userInfoID, $active);
                                $resultLog = $stmtLog->execute();
                            }
                        }

                    } else {
                        // Insertion failed
                        echo json_encode(["error" => "Failed to restore strand"]);
                    }
                    $stmtInsertDepartment->close();

                }
                
            }
        } else {
            echo json_encode(["error" => "Strand not found or invalid ID"]);
        }

        // Close the prepared statement
        $stmtCheckStrand->close();
    } else {
        echo json_encode(["error" => "Invalid input"]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
