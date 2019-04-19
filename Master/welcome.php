<?php
session_start();
// Include config file
require_once "default/connect.php";
// Set session search variables to be empty when returning to this page


if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: Index.php");
    exit;
}

?>
<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Travel Site</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="SitePoint">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="travel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body>
<div id="Search">
    <div id="Nav">
        <ul id="navList">
            <li class="navItemSignUp"><a href="signup.php">Sign Up</a></li>
            <li class="navItem"><a href="login.php">Login</a></li>
        </ul>
    </div>
    <!-- Nav Bar -->
    <div id="searchContainer">
        <div id="intro">
            <h1> Loggin or sign up to access this websites features</h1>
        </div>

    </div>
        <img src="Media/backdropv5.jpg" alt="img">
</div>

</body>
</html>