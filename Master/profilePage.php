<?php
session_start();
// Set ID
$id = $_SESSION["id"];

$eventOutput ='';

// Include config file
require_once "default/connect.php";

// Set session search variables to be empty when returning to this page
$_SESSION["ageSearch"] = '';
$_SESSION["nationalitySearch"] = '';
$_SESSION["favouriteSearch"] = '';
$_SESSION["aboutSearch"] = '';
$_SESSION["imgPathSearch"] = '';

// ----------------------------------------------- Get Profile Details ----------------------------------
// Prepare SQL statment
$sql = "SELECT * FROM user_info WHERE id =$id ";

if($stmt = $pdo->prepare($sql)) {

    // Execute prepared statement
    if ($stmt->execute()) {

        if ($stmt->rowCount() == 1) {
            // Store the results into temp variables
            if ($row = $stmt->fetch()) {
                $id = $row["id"];
                $ageTemp = $row["age"];
                $nationalityTemp = $row["country"];
                $favouriteTemp = $row["favourite"];
                $aboutTemp = $row["bio"];
                $colourTemp = $row["colour"];
                $imgTemp = $row["imgPath"];

                // If these temp variables have all been set then bind there values to session variables
                if(isset($ageTemp, $nationalityTemp, $favouriteTemp, $aboutTemp)){

                    $_SESSION["age"] = $ageTemp;
                    $_SESSION["nationality"] = $nationalityTemp;
                    $_SESSION["favourite"] = $favouriteTemp;
                    $_SESSION["about"] = $aboutTemp;

                    $colour = $row["colour"];

                    $_SESSION["imgPath"] = $imgTemp;
                }
            }
        }
    }

}
// Set variables for Profile name
$name = $_SESSION["firstname"] . " " . $_SESSION["surname"];

$firstName = $_SESSION["firstname"];

// Check If User has set there details
    // Age
    if (!isset ($_SESSION["age"])){
        $age = "-";
    }
    else{
        $age = $_SESSION["age"];
    }

    // Nationality
    if (!isset ($_SESSION["nationality"])){
        $nationality = "-";
    }
    else{
        $nationality = $_SESSION["nationality"];
    }

    //Favourite place to visit
    if (!isset ($_SESSION["favourite"])){
        $favourite = "-";
    }
    else{
        $favourite = $_SESSION["favourite"];
    }

    //About Me
    if (!isset ($_SESSION["about"])){
        $about = "-";
    }
    else{
        $about = $_SESSION["about"];
    }
// ----------------------------------------------- Get Event Details ----------------------------------
// Prepare statement
$qurey = "SELECT eventID FROM users_events WHERE id = '$id' ";

if ($stmt = $pdo->prepare($qurey)) {

    // Execute prepared statement
    if ($stmt->execute()) {

        if ($stmt->rowCount() == 0) {
            $output = "No results Found!";
        } else {
            while ($row = $stmt->fetch()) {

                $searchEventID = $row['eventID'];

                $getEvents = "SELECT * FROM events WHERE eventID = '$searchEventID'";

                if ($stmtGetEvents = $pdo->prepare($getEvents)) {

                    // Execute prepared statement
                    if ($stmtGetEvents->execute()) {
                        // Check if results where found
                        if ($stmtGetEvents->rowCount() !== 0) {

                            while ($row = $stmtGetEvents->fetch()) {

                                $eventID = $row['eventID'];
                                $eventTitle = $row['eventTitle'];
                                $eventDesc = $row['eventDescription'];
                                $eventLoc = $row['location'];
                                $eventStart = $row['eventStartDate'];
                                $eventEnd = $row['eventEndDate'];
                                $eventPrice = $row['eventPrice'];

                                $eventOutput .='<div class="post">';
                                    $eventOutput .= '<a class="eventLink" href="otherUserViewProfile.php?id='.$eventID.'"><h1 id="eventName">'. $eventTitle .'</h1>';
                                    $eventOutput .='<h2 class="eventHeading">'. $eventLoc .'</h2>';
                                    $eventOutput .=' <h2 class="eventHeading">'. $eventStart. ' - ' . $eventEnd .'</h2>';
                                    $eventOutput .=' <h2 class="eventHeading">'.'£'. $eventPrice .'</h2>';

                                    $eventOutput .=' <p>'. $eventDesc .'</p>';
                                $eventOutput .='</div>';


                            }


                        }
                    }
                }
            }
        }

    }
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>

    <script src="js/profileCustomization.js"></script>
</head>

<body>

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
</div>

<!-- Profile Section -->
<div id="profileContainer">


    <!-- Left Side Profile, Personal Details -->
    <div id="profilePersonal" class="pinkBorder">
        <!-- Top Section Of Profile -->
        <div id="profileTopSectionLeft" class="profilePink">

            <a id="editPage" href="editProfile.php"></a>

            <!-- positioning for profile picture -->
            <div id="profilePictureContainer">
             <img id="profilePicture" src="<?php echo $_SESSION['imgPath'] ?>" alt="">
            </div>

            <!-- Name -->
            <h1 id = "profileName"> <?php echo $name ?></h1>
        </div>

        <!-- Main Section Of Profile Page -->
        <div id = "profilePersonalDetails">

            <div id="details" class="details">
                <ul>
                    <li><b>Age:</b> <?php echo $age ?></li>
                    <li><b>Nationality:</b> <?php echo $nationality ?></li>
                    <li><b>Favourite Place To Visit:</b> <?php echo $favourite ?> </li>

                </ul>

            </div>

            <div id="aboutMe" class="aboutMe">
                <h1> About me </h1>
                <p><?php echo $about ?></p>

            </div>

        </div>

    </div>

    <!-- Right Side Profile, Posts -->
    <div id="profilePosts" class="pinkBorder">
        <!-- Right Side Top -->
        <div id="profileTopSectionRight" class="profilePink">
            <!-- Title -->
            <div id="postsTitle">
                <h1><?php echo $firstName ?>'s Events</h1>
            </div>
        </div>

        <!-- Right Side Posts -->
        <div id="posts">
            <?php
               echo $eventOutput;
            ?>
        </div>

    </div>

    <?php
    // Check what colour the user has set there profile to be
    // Then run Function with correct parameter to change colour
    if(isset ($colour)) {
        echo '<script type="text/javascript">';
        echo  'changeBannerColour('.$colour. ');';
        echo '</script>';
    }

    ?>
</div>