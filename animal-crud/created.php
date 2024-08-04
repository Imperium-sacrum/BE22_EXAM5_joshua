<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: ../register-login/login.php");
    exit();
}

if (isset($_SESSION["user"])) {
    header("Location: ../home/home.php");
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
$errormsName = $errormsDescription = "";

if (isset($_POST["create"])) {
    $name = cleanInput($_POST["name"]);
    $photo = fileUpload($_FILES["photo"], "product");
    $location = cleanInput($_POST["location"]);
    $description = cleanInput($_POST["description"]);
    $size = cleanInput($_POST["size"]);
    $age = cleanInput($_POST["age"]);
    $vaccinated = cleanInput($_POST["Vaccinated"]);
    $breed = cleanInput($_POST["breed"]);

    if (empty($name)) {
        $errormsName = "<div class='alert alert-danger' role='alert'>You cannot leave the name empty!</div>";
        $error = true;
    }
    if (empty($description)) {
        $errormsDescription = "<div class='alert alert-danger' role='alert'>You cannot leave the description empty!</div>";
        $error = true;
    }
    $photoName = isset($photo[0]) ? $photo[0] : "default.png";
    $photoMessage = isset($photo[1]) ? $photo[1] : "No message";

    if (!$error) {
        $sql = "INSERT INTO animals (name, photo, location, description, size, age, vaccinated, breed, status) VALUES ('$name', '{$photo[0]}', '$location', '$description', '$size', '$age', '$vaccinated', '$breed', 'Available')";

        if (mysqli_query($connect, $sql)) {
            echo "<div class='alert alert-success' role='alert'>New record has been created. {$photo[1]}</div>";
            header("refresh: 3; url=../Dashboard/dashboard.php");
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error: " . mysqli_error($connect) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Animal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-white border-3" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../Dashboard/dashboard.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="../Dashboard/dashboard.php">Animals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../Dashboard/dashboard-user.php">Users</a>
                    </li>
                </ul>
                <a class="btn btn-danger" href="../logout.php?logout">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Create a New Animal Card</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name">
                <p><?= $errormsName ?></p>
            </div>
            <div class="mb-3">
                <label for="breed" class="form-label">Breed:</label>
                <input type="text" class="form-control" id="breed" name="breed">
            </div>
            <div class="mb-3">
                <label for="size" class="form-label">Size:</label>
                <input type="text" class="form-control" id="size" name="size">
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Picture:</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>
            <div class="mb-3">
                <label class="form-label">Vaccinated:</label><br>
                <input type="radio" id="VaccinatedYes" name="Vaccinated" value="1">
                <label for="VaccinatedYes">Yes</label><br>
                <input type="radio" id="VaccinatedNo" name="Vaccinated" value="0">
                <label for="VaccinatedNo">No</label><br>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age:</label>
                <input type="number" step="0.1" class="form-control" id="age" name="age">
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location:</label>
                <input type="text" class="form-control" id="location" name="location">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description"></textarea>
                <p><?= $errormsDescription ?></p>
            </div>
            <button name="create" type="submit" class="btn btn-primary">Create</button>
            <a href="../Dashboard/dashboard.php" class="btn btn-warning">Dashboard</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>