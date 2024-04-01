<?php
require('../../config/db_connection.php');
 

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if (isset($_POST['RoomID'])) {
        $roomID = $_POST['RoomID'];


          // Fetch room information before deletion
        $sqlRoomInfo = "SELECT RoomNumber FROM rooms WHERE RoomID = ?";
        $stmtRoomInfo = $conn->prepare($sqlRoomInfo);
        $stmtRoomInfo->bind_param("i", $roomID);
        $stmtRoomInfo->execute();
        $resultRoomInfo = $stmtRoomInfo->get_result();
        $rowRoomInfo = $resultRoomInfo->fetch_assoc();
        $roomNumber = $rowRoomInfo['RoomNumber']; // Get RoomNumber

        $newActiveStatus = 10;  // 10 means delete

        $sqlUpdate = "UPDATE rooms SET Active = ? WHERE RoomID = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ii", $newActiveStatus, $roomID);

        if ($stmtUpdate->execute()) {
            // Update was successful
            echo "Room deleted successfully.";

           // Log Activity
           if(isset($_SESSION['Username'])){
            $loginnedUsername = $_SESSION['Username'];

            $sqlUserCheck = "SELECT * FROM userinfo WHERE Username=?";
            $stmtUserCheck = $conn->prepare($sqlUserCheck);
            $stmtUserCheck->bind_param("s", $loginnedUsername);
            $stmtUserCheck->execute();
            $resultUserCheck = $stmtUserCheck->get_result();


            if ($resultUserCheck && $resultUserCheck->num_rows > 0) {
                $row = $resultUserCheck->fetch_assoc();
                $userInfoID = $row['UserInfoID'];

                $activity = 'Delete Room number ' . $roomNumber;
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
            echo "Error deleting rooms: " . $conn->error;
        }

        // Close the prepared statement
        $stmtUpdate->close();
    }
    
    elseif(isset($_POST['StrandID'])){
        $strandID = $_POST['StrandID'];


          // Fetch room information before deletion
          $sqlStrandInfo = "SELECT StrandName FROM strands WHERE StrandID = ?";
          $stmtStrandInfo = $conn->prepare($sqlStrandInfo);
          $stmtStrandInfo->bind_param("i", $strandID);
          $stmtStrandInfo->execute();
          $resultStrandInfo = $stmtStrandInfo->get_result();
          $rowStrandInfo = $resultStrandInfo->fetch_assoc();
          $strandName = $rowStrandInfo['StrandName']; // Get StrandName
       


        $newActiveStatus = 10;  //10 means delete

        $sqlUpdate = "UPDATE strands SET Active = ? WHERE StrandID = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ii", $newActiveStatus, $strandID);

        if ($stmtUpdate->execute()) {
            // Update was successful
            echo "Strand deleted successfully.";

            // Log Activity
            if(isset($_SESSION['Username'])){
                $loginnedUsername = $_SESSION['Username'];

                $sqlUserCheck = "SELECT * FROM userinfo WHERE Username=?";
                $stmtUserCheck = $conn->prepare($sqlUserCheck);
                $stmtUserCheck->bind_param("s", $loginnedUsername);
                $stmtUserCheck->execute();
                $resultUserCheck = $stmtUserCheck->get_result();


                if ($resultUserCheck && $resultUserCheck->num_rows > 0) {
                    $row = $resultUserCheck->fetch_assoc();
                    $userInfoID = $row['UserInfoID'];
    
                    $activity = 'Delete Strand name' .$strandName;
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
            echo "Error deleting strand: " . $conn->error;
        }
            
         // Close the prepared statement
        $stmtUpdate->close();

    }
    elseif(isset($_POST['SubjectID'])){
        $subjectID = $_POST['SubjectID'];

        // Fetch room information before deletion
        $sqlSubjectInfo = "SELECT SubjectName FROM subjects WHERE SubjectID = ?";
        $stmtSubjectInfo = $conn->prepare($sqlSubjectInfo);
        $stmtSubjectInfo->bind_param("i", $subjectID);
        $stmtSubjectInfo->execute();
        $resultSubjectInfo = $stmtSubjectInfo->get_result();
        $rowSubjectInfo = $resultSubjectInfo->fetch_assoc();
        $subjectName = $rowSubjectInfo['SubjectName']; // Get SubjectName

        $newActiveStatus = 10;  //10 means delete

        $sqlUpdate = "UPDATE subjects SET Active = ? WHERE SubjectID = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ii", $newActiveStatus, $subjectID);

        if ($stmtUpdate->execute()) {
            // Update was successful
            echo "Subject deleted successfully.";

             // Log Activity
            if(isset($_SESSION['Username'])){
                $loginnedUsername = $_SESSION['Username'];

                $sqlUserCheck = "SELECT * FROM userinfo WHERE Username=?";
                $stmtUserCheck = $conn->prepare($sqlUserCheck);
                $stmtUserCheck->bind_param("s", $loginnedUsername);
                $stmtUserCheck->execute();
                $resultUserCheck = $stmtUserCheck->get_result();


                if ($resultUserCheck && $resultUserCheck->num_rows > 0) {
                    $row = $resultUserCheck->fetch_assoc();
                    $userInfoID = $row['UserInfoID'];
    
                    $activity = 'Delete Subject name' . $subjectName;
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
            echo "Error deleting subject: " . $conn->error;
        }
            
         // Close the prepared statement
        $stmtUpdate->close();

    }

    elseif(isset($_POST['SectionID'])){
        $sectionID = $_POST['SectionID'];

        // Fetch room information before deletion
        $sqlSectionInfo = "SELECT SectionName FROM classsections WHERE SectionID = ?";
        $stmtSectionInfo = $conn->prepare($sqlSectionInfo);
        $stmtSectionInfo->bind_param("i", $sectionID);
        $stmtSectionInfo->execute();
        $resultSectionInfo = $stmtSectionInfo->get_result();
        $rowSectionInfo = $resultSectionInfo->fetch_assoc();
        $sectionName = $rowSectionInfo['SectionName']; // Get SectionName
        
        $newActiveStatus = 10;  //10 means delete

        $sqlUpdate = "UPDATE classsections SET Active = ? WHERE SectionID = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ii", $newActiveStatus, $sectionID);

        if ($stmtUpdate->execute()) {
            // Update was successful
            echo "Section deleted successfully.";

            // Log Activity
            if(isset($_SESSION['Username'])){
                $loginnedUsername = $_SESSION['Username'];

                $sqlUserCheck = "SELECT * FROM userinfo WHERE Username=?";
                $stmtUserCheck = $conn->prepare($sqlUserCheck);
                $stmtUserCheck->bind_param("s", $loginnedUsername);
                $stmtUserCheck->execute();
                $resultUserCheck = $stmtUserCheck->get_result();


                if ($resultUserCheck && $resultUserCheck->num_rows > 0) {
                    $row = $resultUserCheck->fetch_assoc();
                    $userInfoID = $row['UserInfoID'];
    
                    $activity = 'Delete Class Section name ' . $sectionName;
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
            echo "Error deleting section: " . $conn->error;
        }
            
         // Close the prepared statement
        $stmtUpdate->close();

    }

    

}else {
    echo "Invalid request.";
}
?>
