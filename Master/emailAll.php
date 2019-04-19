<?php
session_start();
// Include config file
require_once "default/errorFunctions.php";
require_once "default/connect.php";

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

if(($_SESSION["userType"] !== 'Committee Member')){
    header("location: Index.php");
    exit;
}

$userEmail = '';
$_SESSION["email"] = $userEmail;

$sql = "SELECT email FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$people = $stmt->fetchAll(PDO::FETCH_OBJ);

foreach($people as $person) {
    $allEmails = $person->email;
}

if(isset($_POST) & !empty($_POST)) {

        $messageAll = trim($_POST["message"]);
        $subject2 = trim($_POST["subject"]);

        $to = $allEmails;
        $subject = $subject2;
        $message = $messageAll;

        $headers = "From : $userEmail";
        if (mail($to, $subject, $message, $headers)) {
            echo "Your email has been sent successfully";
        } else {
            echo "Failed, try again";
        }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Message Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Message All Users</h2>
    <form method="post">
        <div class="form-group">
            <label>Subject: </label>
            <input type="text" name="subject" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Message: </label>
            <input type="text" name="message" class="form-control" required>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit" value="Message">
            <a class="btn btn-link" href="Index.php">Cancel</a>
        </div>

    </form>
</div>
</body>
</html>