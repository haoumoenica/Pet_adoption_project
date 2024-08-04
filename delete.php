<?php
session_start();
if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit();
}

require_once "connection.php";

$pet_id = $_GET["pet_id"];

$sql = "SELECT * FROM pet WHERE pet_id = {$pet_id}";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);



if ($row["picture"] != "pet.png") {
    unlink("pictures/{$row["picture"]}");
}


$sqlDelete = "DELETE FROM `pet` WHERE pet_id = {$pet_id}";
mysqli_query($conn, $sqlDelete);
header("Location: dashboard.php");

// $id = $_GET["pet_id"];
// $sql = "SELECT * FROM `animal` WHERE pet_id = $id ";
// $result = mysqli_query($conn, $sql);
// $row = mysqli_fetch_assoc($result);

// if ($row["picture"] != "pet.png") {
//     unlink("pictures/{$row["picture"]}");
// }

// $sqlDelete = "DELETE FROM `animal` WHERE pet_id = $id ";
// mysqli_query($conn, $sqlDelete);
// header("Location: dashboard.php");


// require_once "connection.php";