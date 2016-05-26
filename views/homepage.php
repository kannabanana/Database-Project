<?php
//Start PHP session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Main page">
    <meta name="author" content="Brandon Lee">

    <title>Welcome to Telly</title>

    <!-- CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/cover.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/Telly.ico">
</head>
<body>
    <p>
        homepage
    </p>
    
    <?php
        print_r($_SESSION);
    ?>
</body>
</html>
