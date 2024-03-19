<?php
// Include your database connection code here
require('../../config/db_connection.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get additionalInfo from the AJAX request
    $additionalInfo = $_POST["additionalInfo"];

    // Set UserFrom and UserTo values
    $fromUser = 3; // Assuming UserFrom value is 2
    $toUser = 2;   // Assuming UserTo value is 3

    // Use NOW() to get the current timestamp
    $insertMessageSql = "INSERT INTO message (Message, CreatedAt, UserFrom, UserTo, Action, Request) 
                         VALUES ('$additionalInfo', NOW(), $fromUser, $toUser, 4, 'Drop')";

    if ($conn->query($insertMessageSql) === TRUE) {
        // If the message insertion is successful, send a success response
        echo json_encode(["success" => true]);
    } else {
        // If there's an error in message insertion, send an error response with debug information
        echo json_encode(["success" => false, "error" => $conn->error, "insertMessageSql" => $insertMessageSql]);
    }
}

// Close the database connection
$conn->close();
?>
