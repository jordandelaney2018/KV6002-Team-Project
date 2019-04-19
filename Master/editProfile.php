<?php
session_start();

//Get id for the profile being edited
$id = $_SESSION["id"];

// See if the user has already set these details before by checking the session variables
$age = $_SESSION["age"];
$country = $_SESSION["nationality"];
$favourite = $_SESSION["favourite"];
$about = $_SESSION["about"];

// Include config file
require_once "default/connect.php";
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

<!-- Edit Profile Form -->
<div id="editDetails">


        <form action="" enctype="multipart/form-data" method="post" id="editDetailsForm">
            <h1 id="editTitle">Edit your personal details</h1>
            <br>
            <!-- Personal Details -->
            <label for="Age" class="last-name">Age</label>
            <input name="age" class="formInput" id="Age" type="text" value="<?php echo htmlspecialchars($age); ?>">

            <label for="Country" class="last-name">Country</label>
            <input name="country" class="formInput" id="Country" type="text"value="<?php echo htmlspecialchars($country); ?>">




            <!-- Extra Favourite Details -->
            <label for="Favourite" class="last-name">Favourite Place You've Visited</label>
            <input name="favourite" class="formInput" id="Favourite" type="text" value="<?php echo htmlspecialchars($favourite); ?>">

            <label for="About" class="last-name">Write About Yourself</label>
            <textarea name="about" rows="4" cols="50" id="About" value="<?php echo htmlspecialchars($about); ?>">

            </textarea>


            <label for="Colour" class="last-name">Change Your Profile Colour</label>
            <select name="colour" id="Colour">
                <option value="1">Pink</option>
                <option value="2">Blue</option>
                <option value="3">Yellow</option>
                <option value="4">Green</option>
                <option value="5">Red</option>
            </select>
            <br>

            <br>
            <input type="hidden" value="100000" name="maxFileSize">
            <label for="upload" class="last-name">Upload Profile Picture</label>
            <input name="upload" id="upload" type="file" accept=".jpg">

            <!-- Submit -->
            <br>
            <input id="formButton" name="submit" type="submit" value="Complete">

        </form>
</div>
</body>

</html>
<?php
$url = 'profilePage.php';
//If submit button clicked
if (isset($_POST['submit'])) {
    // Check fields have all been Filled in
    if (isset($_POST['age'], $_POST['country'],$_POST['favourite'],$_POST['about'],$_POST['colour'])
              && $_POST['age'] !== '' && $_POST['country'] !== '' && $_POST['favourite'] !== '' && $_POST['about'] !== ''
              && $_POST['colour'] !== '') {

        //Set path for uploading profile pictures
        $targetPath = "Media/local/";
        $targetPath=$targetPath.basename($_FILES['upload']['name']);


        $age = $_POST['age'];
        $country = $_POST['country'];
        $favourite = $_POST['favourite'];
        $about = $_POST['about'];
        $colour = $_POST['colour'];

        // Check if user is uploading picture
        if(move_uploaded_file($_FILES['upload']['tmp_name'], $targetPath)){
        $sql = "UPDATE user_info 
                SET age='$age', country='$country', favourite='$favourite', bio='$about', colour='$colour', imgPath='$targetPath'
                WHERE id=$id";
         }
        else{
            $sql = "UPDATE user_info
                SET age='$age', country='$country', favourite='$favourite', bio='$about', colour='$colour'
                WHERE id=$id";

        }
        if($stmt = $pdo->prepare($sql)) {

            // Execute prepared statement
            if ($stmt->execute()) {
                // echo a message to say the UPDATE succeeded
                echo $stmt->rowCount() . " records UPDATED successfully";
            }
        }
        echo "<script type='text/javascript'>document.location.href='{$url}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $url . '">';
    }
    else {
        $message = "Please Fill in all the Fields";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

?>