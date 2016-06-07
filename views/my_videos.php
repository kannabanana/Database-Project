<?php
/* Get videos posted by the current user */

// Start the session
session_start();

// Connect to database
include 'database_configuration.php';

// Declare variables
$uid = $_SESSION['uid'];

// Define query
$sql0 = "SELECT * FROM Videos WHERE uid = '$uid'";
$sql1 = "SELECT * FROM Comments";

// Query to find videos in database
if ($query0 = mysqli_query($conn, $sql0)) {
    $videoCounter = 0;

    // Of video query results, set each of them with session variables
    while ($videoRow = $query0->fetch_assoc()) {
        $_SESSION['myvideos_videoid' . $videoCounter] = $videoRow['vid'];
        $_SESSION['videoname' . $videoCounter]        = $videoRow['videoname'];
        $_SESSION['videolink' . $videoCounter]        = $videoRow['videolink'];
        $videoCounter++;
    }

    // Free result set
    $query0->free();
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Query to find comments in database
if ($query1 = mysqli_query($conn, $sql1)) {
    $commentCounter = 0;

    // Of comment query results, set each of them with session variables
    while ($commentRow = $query1->fetch_assoc()) {
        $_SESSION['commentvideoid' . $commentCounter] = $commentRow['vid'];
        $_SESSION['commentcontent' . $commentCounter] = $commentRow['theComment'];
        $commentCounter++;
    }

    // Free result set
    $query1->free();
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Query to find averages rating in database
for ($i = 0; $i < $videoCounter; $i++) {

    // Define query
    $sql2 = "SELECT AVG(rating) AS RatingAverage FROM Ratings WHERE Ratings.vid =" . $_SESSION['myvideos_videoid' . $i];

    // Of found values, set them to session variables
    if ($query2 = mysqli_query($conn, $sql2)) {
        while ($ratingRow = $query2->fetch_assoc()) {
            $_SESSION['averageRating' . $i] = $ratingRow['RatingAverage'];
        }

        // Free result set
        $query2->free();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
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
 		  <li><a href="http://web.engr.oregonstate.edu/~kannas/database-pr/Database-Project/views/homepage.php">Homepage</a></li>
                      <li><a href="http://web.engr.oregonstate.edu/~kannas/database-pr/Database-Project/views/my_videos.php">My Videos</a></li>
                      <li><a href="http://web.engr.oregonstate.edu/~kannas/database-pr/Database-Project/views/review_video.php">Review Video</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li><a href="http://web.engr.oregonstate.edu/~kannas/database-pr/Database-Project/views/update_profile.php"><?php echo $_SESSION['username']; ?></a></li>
           
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
                      <h3>Your Video Library:</h3>
                      <br />
                      <?php
                      // For each video, render the title and embedded video
                      for ($i = 0; $i < $videoCounter; $i++) {
                          echo '<h4>' . $_SESSION['videoname' . $i] . '</h4>';
                          echo '<iframe width="560" height="315" src="' . $_SESSION['videolink' . $i] . '" frameborder="0" allowfullscreen></iframe>';

                          // If video has an average rating... print it out!
                          if ($_SESSION['averageRating' . $i] != null) {
                              echo '<p id="ratingComment">Average Rating: ' . $_SESSION['averageRating' . $i] . ' out of 5 stars</p>';
                          } else {
                              echo '<p id="ratingComment">This video has not been rated yet.</p>';
                          }

                          echo '<h5>Comments:</h5>';

                          // Check every comment for every video and print comments if relevant to the specific video
                          for ($j = 0; $j < $commentCounter; $j++) {
                              if ($_SESSION['myvideos_videoid' . $i] == $_SESSION['commentvideoid' . $j]) {
                                  echo '<p>' . $_SESSION['commentcontent' . $j] . '</p>';
                              }
                          }
                      }
                      ?>
                  </div>
                  <!-----------------------------Begin Right column --------------------------- -->
                  <div class="col-md-6">
                      <br />
                      <br />
                      <br />

                      <div class="container-fluid">
                          <h3>Upload a video here:</h3>
                          <form data-toggle="validator" role="form" class="form-inline" action="upload_video.php" autocomplete="off" method="post">
                              <div class="form-group">
                                  <input class="form-control" name="videoname" type="text" placeholder="Video Title" required>
                              </div>
                              <div class="form-group">
                                  <input class="form-control" name="videolink" type="text" placeholder="Youtube Video Embed URL" required>
                              </div>
                              <button type="submit" class="btn btn-primary">Upload</button>
                          </form>

                          <br />
                          <br />

                          <h3>Delete a video here:</h3>
                          <form data-toggle="validator" role="form" class="form-inline" action="delete_video.php" autocomplete="off" method="post">
                              <div class="form-group">
                                  <input class="form-control" name="videoname" type="text" placeholder="Video Title" required>
                              </div>
                              <button type="submit" class="btn btn-primary">Delete</button>
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
