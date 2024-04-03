<?php
    require('../../config/db_connection.php');

    session_start();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['SubjectID'])) {
            $subjectID = $_POST['SubjectID'];

            // Check if the Subject with the given ID exists and if it's active
            $stmtCheckSubject = $conn->prepare("SELECT SubjectName, MinutesPerWeek,Active FROM subjects WHERE SubjectID = ?");
            $stmtCheckSubject->bind_param("i", $subjectID);
            $stmtCheckSubject->execute();
            $resultCheckStrand = $stmtCheckSubject->get_result();

            if ($resultCheckStrand->num_rows === 1) {
                $row = $resultCheckStrand->fetch_assoc();
                $subjectDescription = $row['SubjectName'];
                $minPerweek = $row['MinutesPerWeek'];
                $isActive = $row['Active'];

                // Check if the SubjectName exists and is active
                if ($isActive == 1) {
                    // echo "Error: The data already exists and is active.";
                    echo json_encode(["error" => "The data already exists and is active"]); 
                } else {
                    // Check if another record with the same SubjectName is active
                    $stmtCheckActiveSubject = $conn->prepare("SELECT SubjectID FROM subjects WHERE SubjectName = ? AND MinutesPerWeek =? AND Active = 1");
                    $stmtCheckActiveSubject->bind_param("ss", $subjectDescription, $minPerweek);
                    $stmtCheckActiveSubject->execute();
                    $resultCheckActiveSubject = $stmtCheckActiveSubject->get_result();
    
                    if ($resultCheckActiveSubject->num_rows > 0) {
                        // echo "Error: Another active record with the same SubjectName exists.";
                       echo json_encode(["error" => "The data are already in File Maintenance."]);  
                    } else {
                        // Update the Active status in the subjects table
                        $sqlUpdateActive = "UPDATE subjects SET Active = 1 WHERE SubjectID = ?";
                        $stmtUpdateActive = $conn->prepare($sqlUpdateActive);
                        $stmtUpdateActive->bind_param("i", $subjectID);
    
                        if ($stmtUpdateActive->execute()) {
                            // Update was successful
                            echo json_encode(["success" => "Subject restored successfully"]);

                            
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

                                    // $activity = 'Restored room number ';
                                    $activity = 'Restored subject name ' . $subjectDescription;
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
                            echo json_encode(["error" => "Error restoringg subject: " . $conn->error]);
                        }
    
                        // Close the prepared statement
                        $stmtUpdateActive->close();
                    }
                }
            } else{
                echo json_encode(["success" => "Error: Subject does not exist" . $conn->error]);
            }
            // Close the prepared statements
            $stmtCheckSubject->close();
            $stmtCheckActiveSubject->close();
        }
    } else{
        echo json_encode(["error" => "Invalid Request"]);
    }
?>