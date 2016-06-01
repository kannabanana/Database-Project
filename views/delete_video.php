<?php
/* Delete a video to the Telly database */

// Start the session
session_start();

// Connect to database
include 'database_configuration.php';

// Declare variables
$uid       = $_SESSION['uid'];
$videoname = $_POST[videoname];

// Clean input
$cleanVideoName = mysqli_real_escape_string($conn, $videoname);
$cleanVideoLink = mysqli_real_escape_string($conn, $videolink);

// Define query
$sql = "DELETE FROM Videos WHERE Videos.videoname='$videoname' AND Videos.uid = '$uid'";

// Send query
if (mysqli_query($conn, $sql)) {
    // Redirect to homepage after successful upload
    header("Location: http://people.oregonstate.edu/~leebran/Database-Project/views/homepage.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close connection
$conn->close();
?>
