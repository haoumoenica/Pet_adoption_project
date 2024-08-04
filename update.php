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
require_once "file_upload.php";
require_once "footer.php";

$alertMessage = '';
$pet_id = $_GET["pet_id"];

$detailSql = "SELECT * FROM pet WHERE pet_id = {$pet_id}";

$detailResult = mysqli_query($conn, $detailSql);

#one result only,

$row = mysqli_fetch_assoc($detailResult);

if ($row["status"] == "available") {
    $availability_text = "Available";
    $availability_class = "text-success";
} else {
    $availability_text = "{$row["pet_name"]} has found a home, how about one of his friends?";
    $availability_class = "text-danger";
}

if ($row["status"] == "available") {
    $availability_text = "Available";
    $availability_class = "text-success";
    $adopt = "<a href='adopt.php?pet_id={$row["pet_id"]}' class='btn btn-success'>Take me home</a>";
} elseif ($row["status"] == "reserved") {
    $availability_text = "{$row["pet_name"]} is reserved, how about one of his friends?";
    $availability_class = "text-warning";
    $adopt = "";
} else {
    $availability_text = "Not Available";
    $availability_class = "text-danger";
    $adopt = "";
}

$layout = "<div class='col mb-4'>
            <div class='card h-100'>
                <img src='pictures/{$row["picture"]}' class='card-img-top' alt='Pet Image' style='height: auto; max-height: 25rem;'>
                <div class='card-body'>
                    <h5 class='card-title'>{$row["pet_name"]}</h5>
                    <div class='row'>
                        <div class='col-6'>
                            <p class='card-text'><b>Breed:</b> {$row["breed"]}</p>
                            <p class='card-text'><b>Age:</b> {$row["age"]}</p>
                        </div>
                        <div class='col-6'>
                            <p class='card-text'><b>Sex:</b> {$row["sex"]}</p>
                            <p class='card-text'><b>Vaccinated:</b> {$row["vaccinated"]}</p>
                        </div>
                    </div>
                    <p class='card-text'><b>Description:</b><br>{$row["description"]}</p>
                    <p class='card-text {$availability_class}'><b>{$availability_text}</b></p>
                </div>
            </div>
        </div>";


$sql = "SELECT * FROM pet WHERE pet_id = $pet_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_POST["update_pet"])) {
    $pet_name = cleanInput($_POST['pet_name']);
    $age = cleanInput($_POST['age']);
    $description = cleanInput($_POST['description']);
    $address = cleanInput($_POST['address']);
    $size = cleanInput($_POST['size']);
    $breed = cleanInput($_POST['breed']);
    $vaccinated = cleanInput($_POST['vaccinated']);
    $status = cleanInput($_POST['status']);
    $sex = cleanInput($_POST['sex']);
    $picture = fileUpload($_FILES['picture']);



    if ($_FILES["picture"]["error"] == 4) {
        $sqlUpdate = "UPDATE `pet` SET `pet_name`='{$pet_name}',`age`='{$age}',`description`='{$description}',`address`='{$address}',`size`='{$size}',`breed`='{$breed}',`vaccinated`='{$vaccinated}',`status`='{$status}',`sex`='{$sex}' WHERE pet_id = $pet_id";
    } else {
        if ($row["picture"] != "pet.png") {
            unlink("pictures/{$row["picture"]}");
        }
        $sqlUpdate = "UPDATE `pet` SET `pet_name`='{$pet_name}',`picture`='{$picture[0]}',`age`='{$age}',`description`='{$description}',`address`='{$address}',`size`='{$size}',`breed`='{$breed}',`vaccinated`='{$vaccinated}',`status`='{$status}',`sex`='{$sex}' WHERE pet_id = $pet_id";
    }

    $resultUpdate = mysqli_query($conn, $sqlUpdate);


    if (!$resultUpdate) {
        $alertMessage = "<div class='alert alert-danger' role='alert'>Something went wrong, please try again later!</div>";
    } else {
        $alertMessage = "<div class='alert alert-success' role='alert'>Pet record has been successfully updated!</div>";
        header("refresh: 3; url= dashboard.php");
    }

    // echo "<div class='alert alert-success' role='alert'>
    //         Pet record has been updated.
    //       </div>";
    // header("refresh: 3; url= dashboard.php");
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update pet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <nav><?php require_once "./navbar.php"; ?></nav>
    <?= $alertMessage ?>
    <div class="container mt-5">
        <h2>Update Pet</h2>
        <div class="row">
            <div class="col-md-6 mb-4">
                <?= $layout ?>
            </div>
            <div class="col-md-6">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <label for="pet_name" class="form-label">Pet Name</label>
                        <input type="text" class="form-control" id="pet_name" name="pet_name" value="<?= $row['pet_name'] ?>">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?= $row['address'] ?>">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" value="<?= $row['description'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control" id="age" name="age" value="<?= $row['age'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="breed" class="form-label">Breed</label>
                        <input type="text" class="form-control" id="breed" name="breed" value="<?= $row['breed'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="picture" class="form-label">Picture</label>
                        <input type="file" class="form-control" id="picture" name="picture">
                    </div>
                    <div class="mb-3">
                        <label for="size" class="form-label">Size</label>
                        <select class="form-select" id="size" name="size">
                            <option value=""></option>
                            <option value="Small" <?= $row['size'] == 'small' ? 'selected' : '' ?>>Small</option>
                            <option value="Medium" <?= $row['size'] == 'medium' ? 'selected' : '' ?>>Medium</option>
                            <option value="Large" <?= $row['size'] == 'large' ? 'selected' : '' ?>>Large</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value=""></option>
                            <option value="Available" <?= $row['status'] == 'available' ? 'selected' : '' ?>>Available</option>
                            <option value="Adopted" <?= $row['status'] == 'adopted' ? 'selected' : '' ?>>Adopted</option>
                            <option value="Reserved" <?= $row['status'] == 'reserved' ? 'selected' : '' ?>>Reserved</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sex" class="form-label">Sex</label>
                        <select class="form-select" id="sex" name="sex">
                            <option value=""></option>
                            <option value="Male" <?= $row['sex'] == 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= $row['sex'] == 'Female' ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="vaccinated" class="form-label">Vaccinated</label>
                        <select class="form-select" id="vaccinated" name="vaccinated">
                            <option value=""></option>
                            <option value="Yes" <?= $row['vaccinated'] == 'yes' ? 'selected' : '' ?>>Yes</option>
                            <option value="No" <?= $row['vaccinated'] == 'no' ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>
                    <button name="update_pet" type="submit" class="btn btn-primary">Update Pet</button>
                    <a href="index.php" class="btn btn-warning">Back to Home Page</a>
                </form>
            </div>
        </div>
    </div>
    <div><?= $footer ?></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>

</html>