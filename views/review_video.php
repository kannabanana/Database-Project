<?php
/* Get videos posted by the current user */

// Start the session
session_start();

// Connect to database
include 'database_configuration.php';

// Declare variables
$major = $_SESSION['major'];

// Define query
$sql0 = "SELECT * FROM Videos";
$sql1 = "SELECT * FROM Comments";
$sql2 = "SELECT * FROM Keywords";

// Query to find videos in database
if ($query0 = mysqli_query($conn, $sql0)) {
    $videoCounter = 0;

    // Of video query results, set each of them with session variables
    while ($videoRow = $query0->fetch_assoc()) {
        $_SESSION['review_videoid' . $videoCounter]   = $videoRow['vid'];
        $_SESSION['review_videoname' . $videoCounter] = $videoRow['videoname'];
        $_SESSION['review_videolink' . $videoCounter] = $videoRow['videolink'];
        $videoCounter++;
    }

    // Free result set
    $query0->free();
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

if ($query2 = mysqli_query($conn, $sql2)) {
    $keywordcounter = 0;

    // Of video query results, set each of them with session variables
    while ($keywordRow = $query2->fetch_assoc()) {
        $_SESSION['fkeyword1' . $keywordcounter]   = $keywordRow['keyword1'];
        $_SESSION['fkeyword2' . $keywordcounter] = $keywordRow['keyword2'];
        $_SESSION['fkeyword3' . $keywordcounter] = $keywordRow['keyword3'];
        $keywordcounter++;
    }

    // Free result set
    $query2->free();
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
    $sql2 = "SELECT AVG(rating) AS RatingAverage FROM Ratings WHERE Ratings.vid =" . $_SESSION['review_videoid' . $i];

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

<!-- View to rate and comment on videos -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Main page">
    <meta name="author" content="Brandon Lee">

    <title>Telly Review</title>

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
                      <br />
                      <h2><?php echo "Welcome " . $_SESSION['username'] . "!" ?></h2>
                      <!-- Web App Helpful Notes -->
                      <p>
                          This view serves to allow users to rate and comment on videos they've watched!
                          Simply type the name of the video along with your ratings and comments and submit!
                      </p>

                      <h3>Here's a list of videos:</h3>

                      <br />
                      <?php
                      // For each video, render the title and embedded video
                      for ($i = 0; $i < $videoCounter; $i++) {
                          echo '<h4>' . $_SESSION['review_videoname' . $i] . '</h4>';
                          echo '<iframe width="560" height="315" src="' . $_SESSION['review_videolink' . $i] . '" frameborder="0" allowfullscreen></iframe>';

                          // If video has an average rating... print it out!
                          if ($_SESSION['averageRating' . $i] != null) {
                              echo '<p id="ratingComment">Average Rating: ' . $_SESSION['averageRating' . $i] . ' out of 5 stars</p>';
                          } else {
                              echo '<p id="ratingComment">This video has not been rated yet. You should rate it! </p>';
                          }
		

			echo '<h5>Keywords:</h5>';
			for ($k = 0; $k < $keywordcounter; $k++) {
                              if ($_SESSION['fkeyword1' . $i] == $_SESSION['fkeyword1' . $k]) {
                                  echo '<p>' . $_SESSION['fkeyword1' . $k] . '</p>';
		                  echo '<p>' . $_SESSION['fkeyword2' . $k] . '</p>';
		                  echo '<p>' . $_SESSION['fkeyword3' . $k] . '</p>';
	
                              }
                          }

                          echo '<h5>Comments:</h5>';

                          // Check every comment for every video and print comments if relevant to the specific video
                          for ($j = 0; $j < $commentCounter; $j++) {
                              if ($_SESSION['review_videoid' . $i] == $_SESSION['commentvideoid' . $j]) {
                                  echo '<p>' . $_SESSION['commentcontent' . $j] . '</p>';
                              }
                          }
                      }
                      ?>
                  </div>
                  <!-----------------------------Begin Right column --------------------------- -->
                  <div class="col-md-6">
                      <!-- Videos from other users of the same major -->
                      <br />
                      <br />
                      <br />
                      <h3>Review Video:</h3>

                      <div class="container-fluid">
                              <form data-toggle="validator" role="form" autocomplete="off" action="submit_comment.php" method="post">
                                  <div class="form-group col-lg-12">
                                      <label for="videoname" class="control-label">Add a comment</label>
                                      <input name="videoname" type="text" class="form-control" placeholder="Video Name" required>
                                  </div>
                                  <div class="form-group col-lg-12">
                                      <input name="comment" type="text" class="form-control" placeholder="Comment" required>
                                  </div>
                                  <div class="form-group">
                                      <button type="submit" class="btn btn-primary">Submit Comment</button>
                                  </div>
                          </form>
                      <br />
                  </div>

                  <div class="container-fluid">
                          <form data-toggle="validator" role="form" autocomplete="off" action="submit_rating.php" method="post">
                              <div class="form-group col-lg-12">
                                  <label for="videoname" class="control-label">Add a rating</label>
                                  <input name="videoname" type="text" class="form-control" placeholder="Video Name" required>
                                  <label for="rating">Select Rating:</label>
                                  <select class="form-control" name="rating">
                                      <option value="1">1 Stars</option>
                                      <option value="2">2 Stars</option>
                                      <option value="3">3 Stars</option>
                                      <option value="4">4 Stars</option>
                                      <option value="5">5 Stars</option>
                                  </select>
                              </div>
                              <div class="form-group">
                                  <button type="submit" class="btn btn-primary">Submit Rating</button>
                              </div>
                      </form>
                  <br />
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
