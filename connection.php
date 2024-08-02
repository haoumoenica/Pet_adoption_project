<?php

$hostname = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "BE22_EXAM5_animal_adoption_mohammad_afif_haounji";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function cleanInput($input)
{
    $data = trim($input);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);

    return $data;
}
