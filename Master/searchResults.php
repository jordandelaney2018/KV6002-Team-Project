<?php
session_start();
// Include config file
require_once "default/connect.php";
$results = $_SESSION['searchQurey'];


    //Setting what symbols can be used for the search
    $results = preg_replace("#[^0-9a-z]#i", "", $results);

$qurey = "SELECT * FROM users WHERE firstname like '%$results%' OR surname like '%$results%' OR username like '%$results%'";

$eventQurey = "SELECT * FROM events WHERE eventTitle like '%$results%' OR location like '%$results%' OR eventStartDate like '%$results%'";

if ($stmt = $pdo->prepare($qurey)) {

    // Execute prepared statement
    if ($stmt->execute()) {

        if ($stmt->rowCount() == 0) {

        } else {
            $output = '<ul ="dropdown">';
            $output = '<h1 class="searchHeadings"> People </h1>';

            while ($row = $stmt->fetch()) {
                $fname = $row['firstname'];
                $lname = $row['surname'];
                $_SESSION["firstnameSearch"] = $row['firstname'];
                $_SESSION["surnameSearch"] = $row['surname'];
                $username = $row['username'];

                $_SESSION['searchID'] = $row['id'];

                $searchID = $_SESSION['searchID'];

                $output .= '<a id="' . $searchID . '" class="searchResult" href="otherUserViewProfile.php?id=' . $searchID . '"><li> ' . $fname . ' ' . $lname . '</li></a>';
            }
        }

    }
}

if ($stmtEvent = $pdo->prepare($eventQurey)) {
    $output .= '<h1 class="searchHeadings"> Events </h1>';
    // Execute prepared statement
    if ($stmtEvent->execute()) {

        while ($row = $stmtEvent->fetch()) {
            $eventName = $row['eventTitle'];
            $eventLoc = $row['location'];
            $eventDate = $row['eventStartDate'];

            $searchedEventId = $row['eventID'];

            $output .= '<a id="' . $searchedEventId . '" class="searchResult" href="otherUserViewProfile.php?id=' . $searchedEventId . '"><li> ' . $eventName . ' ' . $eventLoc . '</li></a>';
        }
    }
}
$output .= '</ul>';

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

    <script src="js/instantSearch.js"></script>
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
    <div id="searchResults">
        <div id="searchTop">
            <h1 id="searchTitle">Search Results</h1>
        </div>

        <div id="searchMain">
            <?php
            echo($output);
            ?>
        </div>

    </div>
</div>
</body>
</html>