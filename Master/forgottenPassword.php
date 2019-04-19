<?php
// Initialize the session
session_start();


// Include config file
require_once "default/connect.php";

// Validate credentials
if(isset($_POST) & !empty($_POST)) {

$sqlEmail = "SELECT email FROM users WHERE email = :email";

if($stmtEmail = $pdo->prepare($sqlEmail)) {
// Bind variables to the prepared statement as parameters
    $stmtEmail->bindParam(":email", $param_email, PDO::PARAM_STR);

// Set parameters
    $param_email = trim($_POST["email"]);

// Attempt to execute the prepared statement
    if ($stmtEmail->execute()) {
        if ($stmtEmail->rowCount() == 1) {
            $email_err = "This email is already registered.";
        } else {
            $emailTo = trim($_POST["email"]);
        }
    }
}
    $code = uniqid(true);

    $query = "INSERT INTO resetPasswords(code, email) VALUES('$code', '$emailTo')";

    $stmt = $pdo->prepare($query);

    if ($stmt->execute()) {
        $url = "http://". $_SERVER["HTTP_HOST"].dirname($_SERVER["PHP_SELF"])."/resetPassword.php?code=$code";
        $to = $emailTo;
        $subject = "Your Password Reset Link";

        $message = "Your requested password reset link. Click the link to proceed. $url";

        $headers = "From : neetan.briah@northumbria.ac.uk";
        if (mail($to, $subject, $message, $headers)) {
            echo "Your Password has been sent to your registered email";
        } else {
            echo "Failed to Recover your password, try again";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgotten Password</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<div class="wrapper">
    <?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
    <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
    <form class="form-group" method="POST">
        <h2 class="form-signin-heading">Forgotten Password</h2>
        <div class="form-group">
            <p>Recovery email will be sent.</p>
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Forgot Password">
        </div>
        <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
        <p>Reverseee? <a href="login.php">Back to login</a>.</p>
    </form>
</div>
</body>
</html>