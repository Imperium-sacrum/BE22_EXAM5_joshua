<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location:../login.php");
    exit();
}

if (isset($_SESSION["user"])) {
    header("Location:../home/home.php");
    exit();
}

require_once "../components/db_connect.php";
require_once "../components/file_upload.php";

$sqlU = "SELECT * FROM user WHERE user_id = {$_SESSION["adm"]}";
$resultU = mysqli_query($connect, $sqlU);
$rowsU = mysqli_fetch_assoc($resultU);
$userOrAdmin = "
<div class='d-flex'>
    <div class='border border-2 rounded-circle border-light'>
        <img style='width: 45px; height: 45px' class='rounded-circle' src='../images/{$rowsU["picture"]}' alt=''>
    </div>
    <div>
        Hello, {$rowsU["first_name"]}
    </div>
</div>";

$error = false;
$errormstitel = $errormsName = $errormsDescription = "";
$id = $_GET['v'];
$sql = "SELECT * FROM `animals` WHERE animal_id = $id";
$result = mysqli_query($connect, $sql);

if (mysqli_num_rows($result) == 0) {
    $layout .= "<p class='text-white'>No results found</p>";
} else {
    $rows = mysqli_fetch_assoc($result);
}

if (isset($_POST["update"])) {
    $name = cleanInput($_POST["name"]);
    $photo = fileUpload($_FILES["photo"], "product");
    $location = cleanInput($_POST["location"]);
    $description = cleanInput($_POST["description"]);
    $size = cleanInput($_POST["size"]);
    $age = cleanInput($_POST["age"]);
    $vaccinated = cleanInput($_POST["vaccinated"]);
    $breed = cleanInput($_POST["breed"]);

    $photoPath = $rows["photo"]; // Ruta del archivo actual

    // Si se cargó un nuevo archivo
    if ($_FILES["photo"]["error"] != 4) {
        if ($photo['message'] == "Ok") {
            if ($rows["photo"] != "user.png" && file_exists("images/{$rows['photo']}")) {
                unlink("images/{$rows['photo']}");
            }
            $photoPath = $photo['filename'];
        } else {
            // Manejo de errores si no se pudo cargar el archivo
            echo $photo['message'];
            exit();
        }
    }

    $sqlUpdate = "UPDATE `animals` SET 
        `name`='$name', 
        `photo`='$photoPath', 
        `location`='$location', 
        `description`='$description', 
        `size`='$size',
        `age`='$age', 
        `vaccinated`='$vaccinated', 
        `breed`='$breed',
        `status`='Available'
    WHERE animal_id=$id";

    $resultUpdate = mysqli_query($connect, $sqlUpdate);
    if ($resultUpdate) {
        echo "success";
    } else {
        echo "error";
    }
    header("refresh: 3; url=../Dashboard/dashboard.php");

    if (empty($location)) {
        $errormstitel = "<div class='alert alert-danger' role='alert'>
            You cannot leave the location empty!
        </div>";
        $error = true;
    }
    if (empty($name) || empty($breed)) {
        $errormsName = "<div class='alert alert-danger' role='alert'>
            You cannot leave the Name and Breed empty!
        </div>";
        $error = true;
    }
    if (empty($description)) {
        $errormsDescription = "<div class='alert alert-danger' role='alert'>
            You cannot leave the description empty!
        </div>";
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Store</title>
    <link rel="stylesheet" href="../login.php">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- main Navbar for the main page -->
    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body border-botton border-white border-3" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../Dashboard/dashboard.php">Dashbord</a>
            <button class=" navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="../Dashboard/dashboard.php" aria-current="page">Animals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../Dashboard/dashboard-user.php" aria-current="page">Users</a>
                    </li>

                </ul>
                <h6 class="text-white my-2 mx-5"><?= $userOrAdmin ?></h6>
                <a class="btn btn-danger" href="../logout.php?logout" aria-current="page">Logout</a>
                <!-- search form -->
            </div>
        </div>
    </nav>
    <!-- href="search.php?p=<//?= $val ?> -->
    <div class="container mt-5">
        <h2>Update The Pet</h2>
        <!-- formular to create a new dishes and send to database -->
        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3 mt-3">
                <!-- input for the Titel -->
                <label for="location" class="form-label">location:</label>
                <input type="text" class="form-control" id="location" value="<?= $rows['location'] ?>" aria-describedby="location" name="location">
                <p><?= $errormstitel ?></p>
            </div>

            <div class="mb-3 mt-3">
                <!-- input for the type -->
                <label for="vaccinated" class="form-label">Vaccinated:</label>
                <br>
                <!-- <input type="text" class="form-control" id="type" aria-describedby="type" name="type"> -->
                <select type="boleen" name="vaccinated" class="form-control w-25">
                    <option value="null" class="text-center" selected>--the Animal is Vaccinated?--</option>
                    <option value="1" class="text-center">Yes</option>
                    <option value="0" class="text-center">no</option>
                </select>
            </div>

            <div class="mb-3">
                <!-- input for the FirstName and LastName -->
                <label for="name" class="form-label">Name:</label>
                <input type="text" step="0.1" class="form-control" id="name" value="<?= $rows['name'] ?>" aria-describedby="name" name="name">
                <p><?= $errormsName ?></p>
                <label for="breed" class="form-label">Breed:</label>
                <input type="text" step="0.1" class="form-control" id="breed" value="<?= $rows['breed'] ?>" aria-describedby="breed" name="breed">
                <p><?= $errormsName ?></p>
            </div>

            <div class="mb-3">
                <!-- input for the images -->
                <label for="photo" class="form-label">Picture:</label>
                <input type="file" class="form-control" id="photo" aria-describedby="photo" name="photo">
            </div>

            <div class="mb-3 mt-3">
                <!-- input for the Publisher -->
                <label for="age" class="form-label">Age:</label>
                <input type="text" class="form-control" value="<?= $rows['age'] ?>" id="age" aria-describedby="age" name="age">
            </div>

            <div class="mb-3 mt-3">
                <!-- input for the Publisher address -->
                <label for="size" class="form-label">Size:</label>
                <input type="text" class="form-control" id="size" value="<?= $rows['size'] ?>" aria-describedby="size" name="size">
            </div>


            <div class="mb-3">
                <!-- input for the Description -->
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="titel" value="<?= $rows['description'] ?>" aria-describedby="description" name="description"></input>
                <p><?= $errormsDescription ?></p>
            </div>

            <button name="update" type="submit" class="btn btn-primary">Update</button>
            <a href="../Dashboard/dashboard.php" class="btn btn-warning">Back to Dashboard</a>
        </form>
    </div>
</body>

</html>