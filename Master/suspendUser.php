<?php
session_start();

// require the class definition file
require_once('default/setPath.php');
require_once('default/errorFunctions.php');
require_once('default/connect.php');

$id = $_GET['id'];
$query = 'UPDATE users SET suspension = true WHERE id=:id';
$statement = $pdo->prepare($query);
if ($statement->execute([':id' => $id])) {
    header("Location: home_admin.php");
}