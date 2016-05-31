<?php
/* Submit a new user to the Users database */

// Start the session
session_start();

// Connect to database
include 'database_configuration.php';

// Declare variables
$uid     = $_SESSION['uid'];
$title   = $_POST[videoname];
$comment = $_POST[comment];

// Define query
$sql = "INSERT INTO Comments (vid, uid, theComment) SELECT Videos.vid, '$uid', '$comment' FROM Videos WHERE Videos.videoname = '$title'";

// Send query
if (mysqli_query($conn, $sql)) {
    // Redirect to login page after successful registration
    header("Location: http://people.oregonstate.edu/~leebran/Database-Project/views/homepage.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close connection
$conn->close();
?>
