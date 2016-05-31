<?php
/* Submit a new user to the Users database */

// Connect to database
include 'database_configuration.php';

// Declare variables
$uid   = $_SESSION['uid'];
$major = $_POST[major];

// Define query
$sql = "UPDATE Users SET Users.major = '$major' WHERE Users.uid = '$uid'";

// Send query
if (mysqli_query($conn, $sql)) {
    // Redirect to login page after successful registration
    header("Location: http://people.oregonstate.edu/~leebran/Database-Project/views/");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close connection
$conn->close();
?>
