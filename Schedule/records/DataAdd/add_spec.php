<?php
require('../../config/db_connection.php');
session_start();

// Assuming you have a database connection established

// Get the posted data
$instructorID = $_POST['InstructorID'];
$specializations = $_POST['Specializations'];
$active = 1;

// Initialize an array to store successfully added specializations
$addedSpecializations = array();
$duplicateSpecializations = array(); // Array to store duplicate specializations

// Loop through specializations array and insert into the database
foreach ($specializations as $specialization) {
    // Sanitize the data before inserting to prevent SQL injection
    $specialization = mysqli_real_escape_string($conn, $specialization);

    // Check if specialization already exists for the instructor
    $checkQuery = "SELECT COUNT(*) AS count FROM instructorspecializations WHERE InstructorID = '$instructorID' AND SpecializationName = '$specialization'";
    $result = mysqli_query($conn, $checkQuery);
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];

    if ($count > 0) {
        // If specialization already exists, add it to the duplicate array
        $duplicateSpecializations[] = $specialization;
    } else {
        // If specialization doesn't exist, insert it into the database
        $query = "INSERT INTO instructorspecializations (InstructorID, SpecializationName, Active) VALUES ('$instructorID', '$specialization', '$active')";
        
        // Execute query
        if (mysqli_query($conn, $query)) {
            // If insertion is successful, add specialization to the array
            $addedSpecializations[] = $specialization;
        } else {
            // If insertion fails, output the specific error message
            echo "Error adding specialization: " . mysqli_error($conn);
            // Stop the loop to prevent further insert attempts
            break;
        }
    }
}

// Check if any specializations were added successfully
if (!empty($addedSpecializations)) {
    // Output success message along with the list of added specializations
    echo json_encode(array("success" => "Specializations added successfully " ));
} else {
    // If all specializations were duplicates, display a warning message
    echo json_encode(array("warning" => "Specializations already exist for this instructor: " . implode(", ", $duplicateSpecializations)));
}

// Close database connection
mysqli_close($conn);
?>
