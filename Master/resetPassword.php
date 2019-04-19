<?php

// Include config file
require_once "default/errorFunctions.php";
require_once "default/connect.php";

if(!isset($_GET["code"])){
    exit("can not find page!");
}

$code = $_GET["code"];

$emailQuery = "SELECT email FROM resetPasswords WHERE code='$code'";
$stmtEmail = $pdo->prepare($emailQuery);
$stmtEmail->execute();

if($stmtEmail->rowCount() == 0) {
            echo "Error no matching email found in resetPasswords";
        }

// Processing form data when form is submitted
    if (isset($_POST["password"])) {

        $password = $_POST["password"];

        $param_password = password_hash($password, PASSWORD_DEFAULT);

            $row = $stmtEmail->fetch();

            $email = $row["email"];

            // Prepare an update statement
            $query = "UPDATE users SET password = :password WHERE email='$email'";

            if ($queryStmt = $pdo->prepare($query)) {
                // Bind variables to the prepared statement as parameters
                $queryStmt->bindParam(":password", $param_password, PDO::PARAM_STR);

                // Attempt to execute the prepared statement
                if ($queryStmt->execute()) {

                    $deleteSQL = "DELETE FROM resetPasswords WHERE code='$code'";
                    $deleteStmt = $pdo->prepare($deleteSQL);

                    if ($deleteStmt->execute()) {
                        header("location: Index.php");
                    }
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Reset Password</h2>
    <p>Enter your new password.</p>
    <form method="post">

        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit" value="Update Password">
            <a class="btn btn-link" href="Index.php">Cancel</a>
        </div>

    </form>
</div>
</body>
</html>