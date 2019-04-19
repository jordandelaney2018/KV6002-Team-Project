<?php
session_start();
// Include config file
require_once "default/connect.php";
// Set session search variables to be empty when returning to this page
$_SESSION["ageSearch"] = '';
$_SESSION["nationalitySearch"] = '';
$_SESSION["favouriteSearch"] = '';
$_SESSION["aboutSearch"] = '';
$_SESSION["imgPathSearch"] = '';

if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
    header("location: welcome.php");
    exit;
}

if(($_SESSION["userType"] == 'Admin')){
    header("location: home_admin.php");
    exit;
}

if($_SESSION["suspension"] == true){
    header("location: suspensionPage.php");
    exit;
}



// If Text has been entered into the search box and the search button is clicked
if (isset($_POST['submit']) && isset($_POST['search'])){

    //Send search to next page
    $_SESSION['searchQurey'] = $_POST['search'];
    header("location:searchResults.php");
}



// If Text has been entered into the search box and the search button is clicked
if (isset($_POST['submit']) && isset($_POST['search'])){

    //Send search to next page
    $_SESSION['searchQurey'] = $_POST['search'];
    header("location:searchResults.php");
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
<script src=js/instantSearch.js></script>
<!-- Nav Bar -->
<div id="Search">
    <div id="Nav">
        <ul id="navList">
                <li class="navItem"><a href="do_logout.php">Logout</a></li>
                <li class="navItem"><a href="default.asp">Create Event</a></li>
                <li class="navItem"><a href="news.asp">Forum</a></li>
                <li class="navItem"><a href="profilePage.php">Profile </a></li>
                <li class="navItem"><a href="Index.php">Home</a></li>
        </ul>
    </div>

    <!-- Main Section With Search bar -->
        <div id="searchContainer">
            <form action="" method="POST">
                <input id="searchBar" name="search" type="text" size="100" placeholder="Search for your next adventure..." onkeyup="searchq();">
                <button id="submit" name="submit" type="submit"><i class="fa fa-search"></i></button>
            </form>

            <div id="output">

            </div>
        </div>
        <img src="Media/backdropv5.jpg" alt="img">
</div>


</body>
</html>
