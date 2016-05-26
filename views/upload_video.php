<?php
/*Upload a video to the Telly database*/

// Start the session
session_start();

// Database info
$servername = 'mysql.cs.orst.edu';
$dbname     = 'cs340_leebran';
$username   = 'cs340_leebran';
$password   = '9792';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Declare variables
$uid       = $_SESSION['uid'];
$videoname = $_POST[videoname];
$videolink = $_POST[videolink];

// Clean input
$cleanVideoName = mysqli_real_escape_string($conn, $videoname);
$cleanVideoLink = mysqli_real_escape_string($conn, $videolink);

// Define query
$sql = "INSERT INTO Videos (uid, videoname, videolink) VALUES ('$uid', '$videoname', '$videolink')";

// Define query
// $sql = "INSERT INTO Users (username, major, user_password) VALUES ('$username', '$major', '$hashed_password')";

// Send query
if (mysqli_query($conn, $sql)) {
    //Redirect to homepage after successful upload
    header("Location: http://people.oregonstate.edu/~leebran/Database-Project/views/homepage.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close connection
$conn->close();
?>
