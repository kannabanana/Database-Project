<?php
/* Submit a new user to the Users database */

// Connect to database
include 'database_configuration.php';

// Declare variables
$username        = $_POST[username];
$major           = $_POST[major];
$password        = $_POST[password];
$hashed_password = base64_encode(hash('sha256', $password));

// Define query
$sql = "INSERT INTO Users (username, major, user_password) VALUES ('$username', '$major', '$hashed_password')";

// Send query
if (mysqli_query($conn, $sql)) {
    // Redirect to login page after successful registration
header("Location: http://web.engr.oregonstate.edu/~kannas/database-pr/Database-Project/views/homepage.php");

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close connection
$conn->close();
?>
