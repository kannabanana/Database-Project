<?php
//Database info
$servername = 'mysql.cs.orst.edu';
$username = 'cs340_leebran';
$password ='9792';
$dbname = 'cs340_leebran';

//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Declare variables
$username        = $_POST[username];
$major           = $_POST[major];
$password        = $_POST[password];
$hashed_password = base64_encode(hash('sha256', $password));

echo $username;
echo $major;
echo $password;
echo $hashed_password;

// Define query
$sql = "INSERT INTO Users (username, major, user_password) VALUES ('$username', '$major', '$hashed_password')";

// Send query
if (mysqli_query($conn, $sql)) {
    // echo "Student enrollment inserted!";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

//Redirect to login page after registration
header("Location: http://people.oregonstate.edu/~leebran/Database-Project/views/");

// Close connection
$conn->close();
?>
