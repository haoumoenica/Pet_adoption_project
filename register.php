<?php
session_start();

if (isset($_SESSION["admin"])) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit();
}


require_once "connection.php";
require_once "user_file_upload.php";
require_once "footer.php";

$error = false;
$first_name = $last_name = $dob = $picture = $email_address = $address = $password = $rpassword = $phone_number = '';
$first_nameError = $last_nameError = $dobError = $pictureError = $email_addressError = $addressError = $passwordError = $rpasswordError = $phone_numberError = '';

if (isset($_POST['btn-signup'])) {

    $first_name = cleanInput($_POST['first_name']);
    $last_name = cleanInput($_POST['last_name']);
    $dob = cleanInput($_POST['dob']);
    $address = cleanInput($_POST['address']);
    $phone_number = cleanInput($_POST['phone_number']);
    $email_address = cleanInput($_POST['email_address']);
    $password = cleanInput($_POST['password']);
    $rpassword = cleanInput($_POST['rpassword']);
    $picture = userFileUpload($_FILES['picture']);

    if (empty($first_name)) {
        $error = true;
        $first_nameError = "First Name can't be empty!";
    } elseif (strlen($first_name) < 3) {
        $error = true;
        $first_nameError = "First Name can't be less than 2 characters!";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $first_name)) {
        $error = true;
        $first_nameError = "First Name must contain only letters and spaces!";
    }

    if (empty($last_name)) {
        $error = true;
        $last_nameError = "Last Name can't be empty!";
    } elseif (strlen($last_name) < 3) {
        $error = true;
        $last_nameError = "Last Name can't be less than 2 characters!";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $last_name)) {
        $error = true;
        $last_nameError = "Last Name must contain only letters and spaces!";
    }

    if (empty($dob)) {
        $error = true;
        $dobError = "Date of birth can't be empty!";
    }

    if (empty($email_address)) {
        $error = true;
        $email_addressError = "Email is required!";
    } elseif (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $email_addressError = "Please type a valid email!";
    } else {
        $searchIfEmailExists = "SELECT email_address FROM `user` WHERE email_address = '$email_address'";
        $result = mysqli_query($conn, $searchIfEmailExists);
        if (mysqli_num_rows($result) != 0) {
            $error = true;
            $email_addressError = "Email already exists!";
        }
    }

    if (empty($address)) {
        $error = true;
        $addressError = "Address can't be empty!";
    } elseif (strlen($address) < 3) {
        $error = true;
        $addressError = "Address can't be less than 2 characters!";
    }

    if (empty($password)) {
        $error = true;
        $passwordError = "Password can't be empty!";
    } elseif (strlen($password) < 6) {
        $error = true;
        $passwordError = "Password can't be less than 6 characters";
    }

    if (empty($rpassword)) {
        $error = true;
        $passwordError = "Password can't be empty!";
    } elseif (strlen($rpassword) < 6) {
        $error = true;
        $rpasswordError = "Password can't be less than 6 characters";
    }
    if (!$error) {
        if ($rpassword != $password) {
            $error = true;
            $rpasswordError = "Password entries do not match";
        } else {
            $password = hash('sha256', $password);

            $sql = "INSERT INTO `user`(`first_name`, `last_name`, `email_address`, `dob`, `phone_number`, `address`, `picture`, `password`) VALUES ('$first_name','$last_name','$email_address','$dob','$phone_number','$address','$picture','$password')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<div class='alert alert-success' role='alert'>Congratulations, you have successfully created your profile!</div>";
                header("refresh: 3; url= login.php");
            } else {
                echo "Error!";
                header("refresh: 3; url= login.php");
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
    <title>Registration form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div><?php require_once "./navbar.php"; ?></div>
    <div class="container mt-5">
        <h2 class="mb-3">Registration Form</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" method="POST">
            <div class="mb-3">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $first_name ?>">
                <p class="text-danger"><?= $first_nameError ?></p>
            </div>
            <div class="mb-3">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $last_name ?>">
                <p class="text-danger"><?= $last_nameError ?></p>
            </div>
            <div class="mb-3">
                <label for="dob">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?= $dob ?>">
                <p class="text-danger"><?= $dobError ?></p>
            </div>
            <div class="mb-3">
                <label for="picture">Picture:</label>
                <input type="file" class="form-control" id="picture" name="picture">
            </div>
            <div class="mb-3">
                <label for="phone_number">phone_number:</label>
                <input type="number" class="form-control" id="phone_number" name="phone_number" value="<?= $phone_number ?>">
                <p class="text-danger"><?= $phone_numberError ?></p>
            </div>
            <div class="mb-3">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" value="<?= $address ?>">
                <p class="text-danger"><?= $addressError ?></p>
            </div>
            <div class="mb-3">
                <label for="email_address">Email Address:</label>
                <input type="email" class="form-control" id="email_address" name="email_address" value="<?= $email_address ?>">
                <p class="text-danger"><?= $email_addressError ?></p>
            </div>
            <div class="mb-3">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
                <p class="text-danger"><?= $passwordError ?></p>
            </div>
            <div class="mb-3">
                <label for="rpassword">Repeat your password:</label>
                <input type="password" class="form-control" id="rpassword" name="rpassword">
                <p class="text-danger"><?= $rpasswordError ?></p>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-success" name="btn-signup">Register</button>
            </div>
        </form>
        <a href='home.php?id={$row["id"]}' class='btn btn-dark'>To home page</a>
    </div>
    <footer class="bg-light text-center">
        <?= $footer ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>