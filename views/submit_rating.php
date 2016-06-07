<?php
/* Submit a new user to the Users database */

// Start the session
session_start();

// Connect to database
include 'database_configuration.php';

// Declare variables
$uid     = $_SESSION['uid'];
$title   = $_POST[videoname];
$rating  = $_POST[rating];

// Define query
$sql = "INSERT INTO Ratings (vid, uid, rating) SELECT Videos.vid, '$uid', '$rating' FROM Videos WHERE Videos.videoname = '$title'";

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
