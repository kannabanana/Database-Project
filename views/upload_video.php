<?php
/* upload a video to the telly database */

// start the session
session_start();

// connect to database
include 'database_configuration.php';

// declare variables
$uid       = $_session['uid'];
$videoname = $_post[videoname];
$videolink = $_post[videolink];
$keyword1  = $_post[keyword1];
$keyword2  = $_post[keyword2];
$keyword3  = $_post[keyword3];


// clean input
$cleanvideoname = mysqli_real_escape_string($conn, $videoname);
$cleanvideolink = mysqli_real_escape_string($conn, $videolink);
$cleankey1 = mysqli_real_escape_string($conn, $keyword2);
$cleankey2 = mysqli_real_escape_string($conn, $keyword1);
$cleankey3 = mysqli_real_escape_string($conn, $keyword3);


// define query
$sql = "insert into videos (uid, videoname, videolink) values ('$uid', '$videoname', '$videolink')";

$vid = "select vid from videos where uid='$uid' and videoname='$videoname';


// send query
if (mysqli_query($conn, $sql)) {
    //redirect to homepage after successful upload
header("location: http://web.engr.oregonstate.edu/~kannas/database-pr/database-project/views/homepage.php");
} else {
    echo "error: " . $sql . "<br>" . mysqli_error($conn);
}

// close connection
$conn->close();
?>
