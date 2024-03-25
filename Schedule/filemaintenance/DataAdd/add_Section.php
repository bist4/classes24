<?php
session_start();
require('../../config/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $DepartmentID = $_POST['DepartmentID'];
    $Sections = $_POST['Sections'];
    $hasDuplicates = false; // Flag to track duplicates

    foreach ($Sections as $section) {
        
        $SectionName = $section['SectionName'];

        // Check if the SectionName already exists in the 'classsections' table
        $sqlCheckSection = "SELECT SectionName FROM classsections WHERE SectionName = ?";
        $stmtCheckSection = $conn->prepare($sqlCheckSection);
        $stmtCheckSection->bind_param("s", $SectionName);
        $stmtCheckSection->execute();
        $resultCheckSection = $stmtCheckSection->get_result();

       // Check if the SectionNo already exists in the same Department
        $sqlCheckSectionNo = "SELECT SectionID FROM classsections WHERE DepartmentID = ? AND SectionNo = ?";
        $stmtCheckSectionNo = $conn->prepare($sqlCheckSectionNo);
        $stmtCheckSectionNo->bind_param("ii", $DepartmentID, $section['SectionNo']); // Assuming SectionNo is an integer
        $stmtCheckSectionNo->execute();
        $resultCheckSectionNo = $stmtCheckSectionNo->get_result();



        if ($resultCheckSection->num_rows > 0 || $resultCheckSectionNo->num_rows > 0) {
            // If duplicates found, set flag and break the loop
            $hasDuplicates = true;
            break;
        }
    }

    if ($hasDuplicates) {
        $duplicateError = "";
    
        if ($resultCheckSectionNo->num_rows > 0) {
            $duplicateError .= "Section Number already exists in same Department. ";
        }

        
    
        if ($resultCheckSection->num_rows > 0) {
            $duplicateError .= "Section name already exists.";
        }
    
        // Return the specific error message based on the duplicates found
        echo json_encode(["error" => $duplicateError]);
    }else {
        // If no duplicates found, proceed with insertion
        foreach ($Sections as $section) {
      
            $SectionName = $section['SectionName'];
            $SectionNo = $section['SectionNo'];
            $active = 1;

            $sqlInsert = "INSERT INTO classsections (DepartmentID, SectionNo, SectionName, Active, CreatedAt)
                          VALUES (?, ?, ?, ?,NOW())";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param("iisi", $DepartmentID, $SectionNo, $SectionName, $active);
            $resultInsert = $stmtInsert->execute();

            if (!$resultInsert) {
                // Handle insertion failure here
                echo json_encode(["error" => "Failed to insert data. Please try again."]);
                exit();
            }
        }

        // Insertion was successful
        echo json_encode(["success" => "Section(s) added successfully"]);

        // Insert log entry if the UserID exists in the 'users' table
        



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
        
                foreach ($Subjects as $subject) {
                    $subjectCode = $subject['SubjectCode'];
                    $subjectDescription = $subject['SubjectName'];
                    $units = $subject['MinutesPerWeek'];
        
                    $activity = 'Add Subject: ' . $subjectCode . ' (' . $subjectDescription . ', MinutesPerWeek: ' . $units . ')';
                    $currentDateTime = date('Y-m-d H:i:s');
                    $active = 1;
        
                    $sqlLog = "INSERT INTO logs (DateTime, Activity, UserInfoID, Active, CreatedAt) VALUES (?, ?, ?, ?, NOW())";
                    $stmtLog = $conn->prepare($sqlLog);
                    $stmtLog->bind_param("ssii", $currentDateTime, $activity, $userInfoID, $active);
                    $resultLog = $stmtLog->execute(
                }
            }
        }
    }
}
?>
