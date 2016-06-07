<?php

session_start();
// Connect to database
include 'database_configuration.php';
// Declare variables
$uid       = $_SESSION['uid'];
$videoname = $_POST[videoname];
$videolink = $_POST[videolink];
$keyword1  = $_POST[keyword1];
$keyword2  = $_POST[keyword2];
$keyword3  = $_POST[keyword3];

// Clean input
$cleanVideoName = mysqli_real_escape_string($conn, $videoname);
$cleanVideoLink = mysqli_real_escape_string($conn, $videolink);
$URL = str_ireplace("https://youtu.be/", "", $cleanVideoLink);

$cleankey1 = mysqli_real_escape_string($conn, $keyword1);
$cleankey2 = mysqli_real_escape_string($conn, $keyword2);
$cleankey3 = mysqli_real_escape_string($conn, $keyword3);


// Define query
$sql = "INSERT INTO Videos (uid, videoname, videolink) VALUES ('$uid', '$videoname', '$URL')";
$sql2 = "INSERT INTO Keywords (uid,videname,keyword1,keyword2,keyword3) VALUES ('$uid','$videoname','$keyword1','$keyword2','$keyword3')";

// Send query

if (mysqli_query($conn, $sql)) {
	//Redirect to homepage after successful upload
	header("Location: http://web.engr.oregonstate.edu/~kannas/database-pr/Database-Project/views/homepage.php");
}
else {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close connection
$conn->close();
?>

