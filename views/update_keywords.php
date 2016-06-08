<?php

session_start();
// Connect to database
include 'database_configuration.php';
// Declare variables
$uid       = $_SESSION['uid'];
$videoname = $_POST[videoname];
$keyword1  = $_POST[keyword1];
$keyword2  = $_POST[keyword2];
$keyword3  = $_POST[keyword3];

// Clean input
$cleanVideoName = mysqli_real_escape_string($conn, $videoname);

$cleankey1 = mysqli_real_escape_string($conn, $keyword1);
$cleankey2 = mysqli_real_escape_string($conn, $keyword2);
$cleankey3 = mysqli_real_escape_string($conn, $keyword3);


// Define query
$sql = "UPDATE Keywords SET keyword1='$keyword1', keyword2='$keyword2', keyword3='$keyword3' WHERE videoname='$videoname'";

// Send query
if (mysqli_query($conn, $sql)) {
	//Redirect to homepage after successful upload
	header("Location: http://people.oregonstate.edu/~leebran/Database-Project/views/homepage.php");
}
else {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close connection
$conn->close();
?>
