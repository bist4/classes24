<?php
require('../../config/db_connection.php');
session_start();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $status = $_POST['status'];
    $is_primary = isset($_POST['primary']) ? 1 : 0;
    $is_juniorhigh = isset($_POST['juniorhighschool']) ? 1 : 0;
    $is_seniorhigh = isset($_POST['seniorhighschool']) ? 1 : 0;

    // $specializationsArray = isset($_POST['specializations']) ? $_POST['specializations'] : [];
    $instructorIDs = $_POST['InstructorID'];

    // Update instructors table
    foreach ($instructorIDs as $index => $instructorID) {
        $instructorID = $conn->real_escape_string($instructorID); // Escape special characters
        $instructor_sql = "UPDATE instructors SET Status = '$status', is_Primary = $is_primary, is_JuniorHighSchool = $is_juniorhigh, is_SeniorHighSchool = $is_seniorhigh WHERE InstructorID = $instructorID";
        if ($conn->query($instructor_sql) !== TRUE) {
            $response['error'] = "Error updating instructor record: " . $conn->error;
            echo json_encode($response);
            $conn->close();
            exit;
        }
    }
    
    // Log the activity
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
    
            $currentDateTime = date('Y-m-d H:i:s');
            $activity = "Updated instructor records";
            $active = 1;
    
            $sqlLog = "INSERT INTO logs (DateTime, Activity, UserInfoID, Active, CreatedAt) VALUES (?, ?, ?, ?, NOW())";
            $stmtLog = $conn->prepare($sqlLog);
            $stmtLog->bind_param("ssii", $currentDateTime, $activity, $userInfoID, $active);
            $resultLog = $stmtLog->execute();
        }
    }

    // Return success response
    $response['success'] = "Records updated successfully";
    echo json_encode($response);

    // Close connection
    $conn->close();
}
?>
