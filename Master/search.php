<?php
session_start();
// Include config file
require_once "default/connect.php";
$output = '';
// Run if searchVal from InstantSearch is set
if (isset($_POST['searchVal'])) {

    $searchQ = $_POST['searchVal'];
    //Setting what symbols can be used for the search
    $searchQ = preg_replace("#[^0-9a-z]#i", "", $searchQ);

    $qurey = "SELECT * FROM users WHERE firstname like '%$searchQ%' OR surname like '%$searchQ%' OR username like '%$searchQ%'";

    $eventQurey = "SELECT * FROM events WHERE eventTitle like '%$searchQ%' OR location like '%$searchQ%' OR eventStartDate like '%$searchQ%'";

    if ($stmt = $pdo->prepare($qurey)) {

        // Execute prepared statement
        if ($stmt->execute()) {

            if ($stmt->rowCount() == 0) {

            } else {
                $output = '<ul ="dropdown">';
                $output = '<h1 class ="resultsTitle"> People </h1>';

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
        $output .= '<h1 class ="resultsTitle"> Events </h1>';
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
}

echo($output);

?>