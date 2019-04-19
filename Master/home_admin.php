<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

if(($_SESSION["userType"] !== 'Admin')){
    header("location: Index.php");
    exit;
}

if($_SESSION["suspension"] == true){
    header("location: suspensionPage.php");
    exit;
}

// require the class definition file
require_once('default/setPath.php');
require_once('default/errorFunctions.php');
require_once('default/connect.php');


$sql = 'SELECT * FROM users';
$statement = $pdo->prepare($sql);
$statement->execute();
$people = $statement->fetchAll(PDO::FETCH_OBJ);

 ?>

<!doctype html>
<html lang="en">
<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
   </head>

<div class="container">
  <div class="card mt-4">
    <div class="card-header">
      <h2>All Users</h2>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Firstname</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Account Type</th>
            <th>Suspended</th>
          <th>Action</th>
            <th>Suspend</th>
        </tr>
        <?php foreach($people as $person): ?>
          <tr>
            <td><?= $person->id; ?></td>
            <td><?= $person->username; ?></td>
            <td><?= $person->firstname; ?></td>
              <td><?= $person->surname; ?></td>
              <td><?= $person->email; ?></td>
              <td><?= $person->userType; ?></td>
              <td><?= $person->suspension; ?></td>
            <td>
              <a href="editUsers.php?id=<?= $person->id ?>" class="btn btn-info">Edit</a>
                <a onclick="return confirm('Are you sure you want to delete this user?')" href="deleteUsers.php?id=<?= $person->id ?>" class='btn btn-danger'>Delete</a>
            </td>
              <td>
                  <a onclick="return confirm('Are you sure you want to suspend this user?')" href="suspendUser.php?id=<?= $person->id ?>" class='btn btn-info'>Yes</a>
                <a onclick="return confirm('Are you sure you want to unsuspend this user?')" href="unsuspendUser.php?id=<?= $person->id ?>" class='btn btn-info'>No</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
    <a href="passwordReset.php" class="btn btn-warning">Reset Your Password</a>
    <a href="do_logout.php" class="btn btn-danger">Sign Out of Your Account</a>
</div>
</html>