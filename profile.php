<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}
if (isset($_SESSION["admin"])) {
    $session = $_SESSION["admin"];
    $backTo = "dashboard.php";
} else {
    $session = $_SESSION["user"];
    $backTo = "home.php";
}

require_once "connection.php";
require_once "user_file_upload.php";
require_once "footer.php";

$error = false;
$first_name = $last_name = $dob = $picture = $address = $password = $rpassword = $phone_number = $layout = '';
$first_nameError = $last_nameError = $dobError = $pictureError = $addressError = $passwordError = $rpasswordError = $phone_numberError = '';

$user_id = $session;
$profileSql = "SELECT * FROM `user` WHERE user_id = $session";
$profileResult = mysqli_query($conn, $profileSql);
$profileRow = mysqli_fetch_assoc($profileResult);

$layout = "<div class='col mb-4'>
            <div class='card h-20' style='width:15rem'>
                <img src='pictures/{$profileRow["picture"]}' class='card-img-top' alt='user image' style='width:100%'>
                <div class='card-body'>
                    <h5 class='card-title'>Hello {$profileRow["first_name"]} {$profileRow["last_name"]}</h5>
                </div>
            </div>
        </div>";

if (isset($_POST["edit"])) {
    $first_name = cleanInput($_POST["first_name"]);
    $last_name = cleanInput($_POST["last_name"]);
    $address = cleanInput($_POST['address']);
    $phone_number = cleanInput($_POST['phone_number']);
    $dob = cleanInput($_POST["dob"]);
    $picture = userFileUpload($_FILES["picture"]);

    if (empty($first_name)) {
        $error = true;
        $first_nameError = "First Name can't be empty!";
    } elseif (strlen($first_name) < 3) {
        $error = true;
        $first_nameError = "First Name can't be less than 3 characters!";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $first_name)) {
        $error = true;
        $first_nameError = "First Name must contain only letters and spaces!";
    }

    if (empty($last_name)) {
        $error = true;
        $last_nameError = "Last Name can't be empty!";
    } elseif (strlen($last_name) < 3) {
        $error = true;
        $last_nameError = "Last Name can't be less than 3 characters!";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $last_name)) {
        $error = true;
        $last_nameError = "Last Name must contain only letters and spaces!";
    }

    if (empty($dob)) {
        $error = true;
        $dobError = "Date of birth can't be empty!";
    }

    if (!$error) {
        if ($_FILES["picture"]["error"] != 4) {
            if ($profileRow["picture"] != 'user.png') {
                $oldPicturePath = "pictures/" . $profileRow["picture"];
                if (file_exists($oldPicturePath)) {
                    unlink($oldPicturePath);
                }
            }
            $sqlUpdate = "UPDATE `user` SET first_name = '$first_name', last_name = '$last_name', dob= '$dob', picture = '$picture' WHERE user_id = $session";
        } else {
            $sqlUpdate = "UPDATE `user` SET first_name = '$first_name', last_name = '$last_name', dob= '$dob' WHERE user_id = $session";
        }

        $resultUpdate = mysqli_query($conn, $sqlUpdate);

        if (!$resultUpdate) {
            echo "<div class='alert alert-danger' role='alert'>
                <h3>Something went wrong, please try again later!</h3>
            </div>";
        } else {
            echo "<div class='alert alert-success' role='alert'>Congratulations, you have successfully updated your profile!</div>";
            header("refresh: 3; Location:" . $backTo);
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div><?php require_once "./navbar.php"; ?></div>
    <div class="container mt-5" style="width:25rem">
        <h1>Edit profile!</h1>
        <div><?= $layout ?></div>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" method="POST">
            <div class="mb-3">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($profileRow['first_name']) ?>">
                <p class="text-danger"><?= $first_nameError ?></p>
            </div>
            <div class="mb-3">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($profileRow['last_name']) ?>">
                <p class="text-danger"><?= $last_nameError ?></p>
            </div>
            <div class="mb-3">
                <label for="dob">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?= htmlspecialchars($profileRow['dob']) ?>">
                <p class="text-danger"><?= $dobError ?></p>
            </div>
            <div class="mb-3">
                <label for="picture">Picture:</label>
                <input type="file" class="form-control" id="picture" name="picture">
            </div>
            <div class="mb-3">
                <label for="phone_number">Phone number:</label>
                <input type="number" class="form-control" id="phone_number" name="phone_number" value="<?= htmlspecialchars($profileRow['phone_number']) ?>">
                <p class="text-danger"><?= $phone_numberError ?></p>
            </div>
            <div class="mb-3">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($profileRow['address']) ?>">
                <p class="text-danger"><?= $addressError ?></p>
            </div>
            <input type="submit" name="edit" value="Update profile" class="btn btn-warning">
        </form>
    </div>
    <div><?= $footer ?></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>