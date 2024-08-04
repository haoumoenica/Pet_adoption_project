<?php
session_start();

if (isset($_SESSION["user"])) {
    header("Location: home.php");
}
if (isset($_SESSION["admin"])) {
    header("Location: dashboard.php");
    exit();
}

require_once "connection.php";
require_once "footer.php";

$sql = "SELECT * FROM pet";

$result = mysqli_query($conn, $sql);

$layout = "";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        if ($row["status"] == "available") {
            $availability_text = "Available";
            $availability_class = "text-success";
            $adopt = "<a href='login.php' class='btn btn-info text-white'>Login to adopt</a>";
        } elseif ($row["status"] == "reserved") {
            $availability_text = "Reserved";
            $availability_class = "text-warning";
            $adopt = "";
        } else {
            $availability_text = "Not Available";
            $availability_class = "text-danger";
            $adopt = "";
        }


        $layout .= "<div class='col mb-4'>
                        <div class='card h-100' style='width: 25rem';>
                            <div class='h-50'><img src='pictures/{$row["picture"]}' class='card-img-top'  alt='Pet Image' style='height: 20rem'; ></div>
                            <div class='card-body'>
                                <h5 class='card-title'>{$row["pet_name"]}</h5>
                                <p class='card-text'><b>Breed:</b> {$row["breed"]}</p>
                                <p class='card-text'><b>Age:</b> {$row["age"]}</p>
                                <p class='card-text'><b>Sex:</b> {$row["sex"]}</p>
                                <p class='card-text'><b>Vaccinated:</b> {$row["vaccinated"]}</p>
                                <p class='card-text {$availability_class}'><b>{$availability_text}</b></p>
                                <span>$adopt</span>
                            </div>
                        </div>
                    </div>";
    }
} else {
    $layout = "<p>No results found</p>";
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Car Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div><?php require_once "./navbar.php"; ?></div>
    <div class="container mt-5">
        <h1 class="mt-5">Our pets</h1>
        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1">
            <?= $layout ?>
        </div>
    </div>
    <footer class="mt-auto fixed">
        <?= $footer ?>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>