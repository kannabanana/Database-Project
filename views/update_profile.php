<?php
/* Update the current user */

// Start the session
session_start();

// Connect to database
include 'database_configuration.php';

// Declare variables
$uid = $_SESSION['uid'];

// Define query
$sql = "SELECT * FROM Videos WHERE uid = '$uid'";

// Query to find videos in database
if ($query = mysqli_query($conn, $sql)) {
    $videoCounter = 0;

    // Of video query results, set each of them with session variables
    while ($videoRow = $query->fetch_assoc()) {
        $_SESSION['videoname' . $videoCounter] = $videoRow['videoname'];
        $_SESSION['videolink' . $videoCounter] = $videoRow['videolink'];
        $videoCounter++;
    }

    // Free result set
    $query->free();
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close connection
$conn->close();
?>

<!-- My Videos page for logged in user -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Main page">
    <meta name="author" content="Brandon Lee">

    <title>My Videos</title>

    <!-- CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/cover.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/Telly.ico">
</head>
<body>
    <!-- --------------------------------- The two main wrappers for the site --------------------------------- -->
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
    <!-- --------------------------------- Navigation Bar --------------------------------- -->
          <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
              <div class="container">
                  <div class="navbar-header">
                      <a class="navbar-brand" href="#">Telly</a>
                  </div>
                  <ul class="nav navbar-nav">
                      <li><a href="http://people.oregonstate.edu/~leebran/Database-Project/views/homepage.php">Homepage</a></li>
                      <li><a href="http://people.oregonstate.edu/~leebran/Database-Project/views/my_videos.php">My Videos</a></li>
                      <li><a href="http://people.oregonstate.edu/~leebran/Database-Project/views/review_video.php">Review Video</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li><a href="http://people.oregonstate.edu/~leebran/Database-Project/views/update_profile.php"><?php echo $_SESSION['username']; ?></a></li>
                  </ul>
                  <form data-toggle="validator" role="form" class="navbar-form pull-right" action="submit_logout.php" method="post">
                      <button type="submit" class="btn">Logout</button>
                  </form>
              </div>
          </div>
        <!----------------------End nav bar and begin main page, left column----------------- -->
          <div class="container">
              <div class="row">
                  <div class="col-md-6">
                      <br />
                      <br />
                      <br />
                      <h3><?php echo "Hi " . $_SESSION['username'] . "!" ?></h3>

                      <!-- Web App Helpful Notes -->
                      <p>
                          This is where you can update your profile, just fill the columns on the right and submit! Please note however that in order
                          for the changes to take effect, you will be logged out and asked to log back in.
                      </p>
                  </div>
                  <!-----------------------------Begin Right column --------------------------- -->
                  <div class="col-md-6">
                      <br />
                      <br />
                      <br />

                      <div class="container-fluid">
                          <h3>Change your major here:</h3>
                          <form data-toggle="validator" role="form" class="form-inline" action="update_major.php" autocomplete="off" method="post">
                              <div class="form-group">
                                  <input class="form-control" name="major" type="text" placeholder="Major" required>
                              </div>
                              <button type="submit" class="btn btn-primary">Upload</button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
        </div>
    </div>
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- Validation Library -->
    <script src="../js/validator.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-rc1/jquery.js"></script>
</body>
</html>
