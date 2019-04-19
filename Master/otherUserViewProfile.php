<?php
session_start();

$id = $_GET['id'];
$eventOutput ='';


//If searching for your own profile redirect the main profile page
if($id == $_SESSION['id']){
    header("location:profilePage.php");
}
// Include config file
require_once "default/connect.php";

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

                    $_SESSION["ageSearch"] = $ageTemp;
                    $_SESSION["nationalitySearch"] = $nationalityTemp;
                    $_SESSION["favouriteSearch"] = $favouriteTemp;
                    $_SESSION["aboutSearch"] = $aboutTemp;
                    $colour = $row["colour"];

                    $_SESSION["imgPathSearch"] = $imgTemp;
                }
            }
        }
    }

}

// Prepare SQL statment
$sqlGetName = "SELECT * FROM users WHERE id =$id ";

if($stmtGetName = $pdo->prepare($sqlGetName)) {

    // Execute prepared statement
    if ($stmtGetName->execute()) {

        if ($stmtGetName->rowCount() == 1) {
            // Store the results into temp variables
            if ($row = $stmtGetName->fetch()) {
                $id = $row["id"];
               $firstName = $row['firstname'];
               $surName = $row['surname'];

                }
            }
        }
}

$name = $firstName . " " . $surName;

// Check If User has set there details
// Age
if (!isset ($_SESSION["ageSearch"])){
    $age = "-";
}
else{
    $age = $_SESSION["ageSearch"];
}

// Nationality
if (!isset ($_SESSION["nationalitySearch"])){
    $nationality = "-";
}
else{
    $nationality = $_SESSION["nationalitySearch"];
}

//Favourite place to visit
if (!isset ($_SESSION["favouriteSearch"])){
    $favourite = "-";
}
else{
    $favourite = $_SESSION["favouriteSearch"];
}

//About Me
if (!isset ($_SESSION["aboutSearch"])){
    $about = "-";
}
else{
    $about = $_SESSION["aboutSearch"];
}

//Image Path
if (!isset ($_SESSION["imgPathSearch"])){
   $imgPath = "Media/local/blank.jpg";
}
else{
    $imgPath = $_SESSION["imgPathSearch"];
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
            <!-- positioning for profile picture -->
            <div id="profilePictureContainer">
                <img id="profilePicture" src="<?php echo $imgPath ?>" alt="">
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