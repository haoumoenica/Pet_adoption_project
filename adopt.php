<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: index.php");
}

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
if (isset($_SESSION["admin"])) {
    header("Location: dashboard.php");
    exit();
}

require_once "connection.php";
require_once "footer.php";



$error = false;
$pick_up_date = $pick_up_dateError = "";
$pet_id = $_GET["pet_id"];
$detailSql = "SELECT * FROM animal WHERE pet_id = {$pet_id}";

$detailResult = mysqli_query($conn, $detailSql);
$detailRow = mysqli_fetch_assoc($detailResult);

$layout = "<div class='col mb-4'>
            <div class='card h-50' style='width:25rem';>
                <img src='pictures/{$detailRow["picture"]}' class='card-img-top' alt='Pet Image' style='height: auto; max-height: 15rem;'>
                <div class='card-body'>
                    <h5 class='card-title'>{$detailRow["pet_name"]}</h5>
                    <div class='row'>
                        <div class='col-6'>
                            <p class='card-text'><b>Breed:</b> {$detailRow["breed"]}</p>
                            <p class='card-text'><b>Age:</b> {$detailRow["age"]}</p>
                        </div>
                        <div class='col-6'>
                            <p class='card-text'><b>Sex:</b> {$detailRow["sex"]}</p>
                            <p class='card-text'><b>Vaccinated:</b> {$detailRow["vaccinated"]}</p>
                        </div>
                    </div>
                    <p class='card-text'><b>Description:</b><br>{$detailRow["description"]}</p>
                </div>
            </div>
        </div>";


if (isset($_POST["adopt"])) {
    $pick_up_date = cleanInput($_POST['pick_up_date']);
    $sql = "SELECT * FROM animal WHERE pet_id = {$pet_id}";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $userId = $_SESSION["user"];
    if (empty($pick_up_date)) {
        $error = true;
        $pick_up_dateError = "Pick up date can't be empty!";
        if (!$error) {
            if ($row["status"] == "available") {
                $adoptionSql = "INSERT INTO `adoption`(`adoption_status`, `requested_at`, `pick_up_date`, `insurance`, `user_id`, `pet_id`, `status`) VALUES ('$adoption_status','$requested_at','$pick_up_date','$insurance','$user_id','$pet_id', 'pending')";
                $sqlUpdate = "UPDATE `animal` SET `status`='adopted', WHERE pet_id = $pet_id";
                mysqli_query($conn, $adoptionSql);
                mysqli_query($conn, $sqlUpdate);
                header("Location: home.php");
            }
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pet Adoption</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div><?php require_once "./navbar.php"; ?></div>

    <div class="container mt-5">
        <h1 class="mt-5">Adoption details:</h1>
        <div><?= $layout ?></div>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="from" class="form-label">Pickup date:</label>
                <input type="date" class="form-control" id="pick_up_date" aria-describedby="pick_up_date" name="pick_up_date">
                <p class="text-danger"><?= $pick_up_dateError ?></p>
            </div>
            <div class="mb-3">
                <label for="size" class="form-label">Would you like to purchase insurance for <b><?= $detailRow["pet_name"] ?></b> ?</label>
                <select class="form-select" id="size" name="size">
                    <option value=""></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <button name="adopt" type="submit" class="btn btn-success">Reserve for Adoption</button>
            <a href="home.php" class="btn btn-warning">Back to home page</a>

    </div>

    </form>
    </div>
    <div><?= $footer ?></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>