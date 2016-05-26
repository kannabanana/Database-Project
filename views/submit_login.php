<?php
/* Main login script */

// Start PHP Session
session_start();

// Connect to database
include 'database_configuration.php';

// Declare variables
$username        = $_POST[username];
$password        = $_POST[password];
$hashed_password = base64_encode(hash('sha256', $password));

// Clean username input
$cleanUser = mysqli_real_escape_string($conn, $username);

// Clean password input and encrypt for database comparison
$cleanPassword = mysqli_real_escape_string($conn, base64_encode(hash('sha256', $password)));

// Define query
$sql = "SELECT * FROM Users WHERE username = '$cleanUser' AND user_password = '$cleanPassword'";

// Query to find user in database
if ($query = mysqli_query($conn, $sql)) {

    // Fetch row and create into array
    $userRow = mysqli_fetch_array($query);

    // Check cid for valid account info
    if (strlen($userRow[0]) < 1) {
        die ('Invalid Username or Password');
    }

    // Create session variables
    $_SESSION['uid']      = $userRow[0];
    $_SESSION['username'] = $userRow[1];
    $_SESSION['major']    = $userRow[3];

    // Redirect to user homepage
    header("Location: http://people.oregonstate.edu/~leebran/Database-Project/views/homepage.php");

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close connection
$conn->close();
?>
