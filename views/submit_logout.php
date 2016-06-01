<?php
/* Main logout script */

// Start Session
session_start();

// Remove all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: http://people.oregonstate.edu/~leebran/Database-Project/views/");

?>
