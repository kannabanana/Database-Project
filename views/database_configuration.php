<?php
/* Script to login into database */

// Database info
$servername = 'mysql.cs.orst.edu';
$username   = 'cs340_leebran';
$password   ='9792';
$dbname     = 'cs340_leebran';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
