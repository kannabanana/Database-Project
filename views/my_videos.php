<?php
/* Get videos posted by the current user */

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
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li><a href="#"><?php echo $_SESSION['username']; ?></a></li>
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
                      <h2>Your Video Library:</h2>
                      <br />
                      <?php
                      // For each video, render the title and embedded video
                      for ($i = 0; $i < $videoCounter; $i++) {
                        echo '<h4>' . $_SESSION['videoname' . $i] . '</h4>';
                        echo '<iframe width="560" height="315" src="' . $_SESSION['videolink' . $i] . '" frameborder="0" allowfullscreen></iframe>';
                      }
                      ?>
                  </div>
                  <!-----------------------------Begin Right column --------------------------- -->
                  <div class="col-md-6">
                      <!-- Videos from other users -->
                      <h3>Checkout these videos from your fellow Telly users!</h3>
                      <img src="images/default_profile_photo.png" width='50' height ='50'>
                      <?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?>
                      <h3><?php echo 'Status: '; echo $_SESSION['status']; ?></h3>
                      <br>
                      <!-- Form to update status -->
                      <form class="form-inline" role="form" autocomplete="off" action="update_status.php" method="post">
                          <div class="form-group">
                              <input name="status" type="text" class="form-control" placeholder="What's on your mind?">
                              <button type="submit" class="btn btn-primary">Update</button>
                          </div>
                      </form>
                      <iframe width="560" height="315" src="https://www.youtube.com/embed/DDyT-Nynl8w" frameborder="0" allowfullscreen></iframe>
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
