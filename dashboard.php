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
require_once "footer.php";

$sqlUser = "SELECT * FROM `user` WHERE user_id = " . $_SESSION["admin"];

$resultUser = mysqli_query($conn, $sqlUser);
$rowUser = mysqli_fetch_assoc($resultUser);
$sql = "SELECT pet.*, adoption.pet_id as adoption_pet_id,adoption.adoption_status,adoption.pick_up_date,adoption.confirmation_status, adoption.insurance FROM `pet` left join `adoption` on pet.pet_id = adoption.pet_id;";

$result = mysqli_query($conn, $sql);

$layout = "";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $status = "";
        $confirmation = "";
        if ($row["status"] == "available") {
            $availability_text = "Available";
            $availability_class = "text-success";
            $confirmation = "";
        } else {
            $availability_text = "Not Available";
            $availability_class = "text-danger";
            if ($row["adoption_status"] == "pending") {
                $status = "<p class='card-text'><b>Status:</b> {$row["status"]}</p>";
                $confirmation = "<a href='#' class='btn btn-primary'>Confirm Adoption!</a>";
            }
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
                                <a href='details.php?pet_id={$row["pet_id"]}' class='btn btn-warning text-white'>Details</a>
                                <a href='update.php?pet_id={$row["pet_id"]}' class='btn btn-info text-white'>Update</a>
                                <a href='delete.php?pet_id={$row["pet_id"]}' class='btn btn-danger'>Delete</a>
                                <div class='mt-3'>$confirmation</div>
                            </div>
                        </div>
                    </div>";
    }
} else {
    $layout = "<p>No results found</p>";
}

mysqli_close($conn);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Petstore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div><?php require_once "./navbar.php"; ?></div>
    <div class="container mt-5">
        <h1>Welcome <?= $rowUser["first_name"] . " " . $rowUser["last_name"] ?></h1>
    </div>
    <div class="container mt-5">
        <a class="btn btn-primary" href="create.php">Add a pet</a>
        <h1 class="mt-5">Pets list</h1>
        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1">
            <?= $layout ?>
        </div>
    </div>
    <div><?= $footer ?></div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>