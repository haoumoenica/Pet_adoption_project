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
require_once "navbar.php";
require_once "footer.php";

if (isset($_POST["add_pet"])) {
    $pet_name = cleanInput($_POST['pet_name']);
    $age = cleanInput($_POST['age']);
    $description = cleanInput($_POST['description']);
    $address = cleanInput($_POST['address']);
    $size = cleanInput($_POST['size']);
    $breed = cleanInput($_POST['breed']);
    $vaccinated = cleanInput($_POST['vaccinated']);
    $sex = cleanInput($_POST['sex']);
    $picture = fileUpload($_FILES['picture']);

    $sql = "INSERT INTO `animal`(`pet_name`, `picture`, `age`, `description`, `address`, `size`, `breed`, `vaccinated`, `sex`) VALUES ('$pet_name','{$picture[0]}','$age','$description','$address','$size','$breed','$vaccinated','$sex')";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success' role='alert'>
            New record has been created.
          </div>";
        header("refresh: 3; url= dashboard.php");
    } else {
        echo "<div class='alert alert-danger' role='alert'>
            error found.
          </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a pet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div><?php require_once "./navbar.php"; ?></div>
    <div class="container mt-5">
        <h2>Add a new pet</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="pet_name" class="form-label">Pet Name</label>
                <input type="text" class="form-control" id="pet_name" aria-describedby="pet_name" name="pet_name">
            </div>
            <div class="mb-3 mt-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" aria-describedby="address" name="address">
            </div>
            <div class="mb-3 mt-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" aria-describedby="description" name="description">
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" aria-describedby="age" name="age">
                <div class="mb-3">
                    <label for="breed" class="form-label">Breed</label>
                    <input type="text" class="form-control" id="breed" aria-describedby="breed" name="breed">
                </div>
                <div class="mb-3">
                    <label for="picture" class="form-label">Picture</label>
                    <input type="file" class="form-control" id="picture" aria-describedby="picture" name="picture">
                </div>
                <div class="mb-3">
                    <p>Size:</p>
                    <select class="form-select" aria-label="Default select example" name="size">
                        <option value=""></option>
                        <option value="small">Small</option>
                        <option value="sedium">Medium</option>
                        <option value="large">Large</option>
                    </select>
                </div>
                <div class="mb-3">
                    <p>Sex:</p>
                    <select class="form-select" aria-label="Default select example" name="sex">
                        <option value=""></option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="mb-3">
                    <p>Vaccinated:</p>
                    <select class="form-select" aria-label="Default select example" name="vaccinated">
                        <option value=""></option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <button name="add_pet" type="submit" class="btn btn-primary">Add pet</button>
                <a href="index.php" class="btn btn-warning">Back to home page</a>
        </form>
    </div>
    </div>
    <div><?= $footer ?></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>