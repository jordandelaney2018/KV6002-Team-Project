<?php
// Include config file
require_once "default/connect.php";
session_start();
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$firstname = $surname = $email = "";
$firstname_err = $surname_err = $email_err = "";
$userType= $committee = $committee_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate firstname
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter a forname.";
    } else{
        $firstname = trim($_POST["firstname"]);
    }
    // Validate surname
    if(empty(trim($_POST["surname"]))){
        $surname_err = "Please enter a surname.";
    } else{
        $surname = trim($_POST["surname"]);
    }
// Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{
        // Prepare a select statement
        $sqlEmail = "SELECT email FROM users WHERE email = :email";
        if($stmtEmail = $pdo->prepare($sqlEmail)){
            // Bind variables to the prepared statement as parameters
            $stmtEmail->bindParam(":email", $param_email, PDO::PARAM_STR);
            // Set parameters
            $param_email = trim($_POST["email"]);
            // Attempt to execute the prepared statement
            if($stmtEmail->execute()){
                if($stmtEmail->rowCount() == 1){
                    $email_err = "This email is already registered.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        unset($stmtEmail);
    }
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = :username";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            // Set parameters
            $param_username = trim($_POST["username"]);
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        unset($stmt);
    }
    if(empty (trim($_POST["committee"]))){
        $userType= "Member";
    }

    // Validate type
    if(trim($_POST["committee"]) == '12345'){
        $userType = 'Committee Member';
    }else{
        echo "Incorrect verification code.";
    }
    if(isset($_POST["admin"]) && (isset($_POST["committee"]))){
        echo "You can not register as both admin and committee member.";
    }
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err)
        && empty($surname_err) && empty($email_err) && empty($admin_err) && empty($committee_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, email, firstname, surname, userType) VALUES (:username, :password, :email, :firstname, :surname, :userType)";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":firstname", $param_firstname, PDO::PARAM_STR);
            $stmt->bindParam(":surname", $param_surname, PDO::PARAM_STR);
            $stmt->bindParam(":userType", $param_userType, PDO::PARAM_STR);
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email = $email;
            $param_firstname = $firstname;
            $param_surname = $surname;
            $param_userType = $userType;
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $last_id = $pdo->lastInsertId();
                $sql2 ="INSERT INTO user_info (id) VALUES (:last_id)";
                if($stmt2 = $pdo->prepare($sql2)) {
                    $stmt2->bindParam(":last_id", $param_last_id, PDO::PARAM_STR);
                    $param_last_id = $last_id;
                    if($stmt2->execute()) {
                        // Redirect to login page
                        header("location: login.php");
                    }
                }
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        unset($stmt);
    }
    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Sign Up</h2>
    <p>Please fill this form to create an account.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
            <label>Forename</label>
            <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
            <span class="help-block"><?php echo $firstname_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($surname_err)) ? 'has-error' : ''; ?>">
            <label>Surname</label>
            <input type="text" name="surname" class="form-control" value="<?php echo $surname; ?>">
            <span class="help-block"><?php echo $surname_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
            <span class="help-block"><?php echo $email_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($committee_err)) ? 'has-error' : ''; ?>">
            <label>Committee Member?</label>
            <p>Please enter the validation code below!</p>
            <input type="text" name="committee" class="form-control" value="<?php echo $committee; ?>">
            <span class="help-block"><?php echo $committee_err; ?></span>
        </div>


        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
        <p>Forgot your password? <a href="forgottenPassword.php">Reset Password</a>.</p>
    </form>
</div>
</body>
</html>