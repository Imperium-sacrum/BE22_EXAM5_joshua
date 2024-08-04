<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) { // si la sesión de usuario y la sesión adm no tienen valor
    header("Location: ../login.php"); // redirige al usuario a la página de inicio de sesión
    exit();
}
if (isset($_SESSION["adm"])) { // si existe una sesión "adm" con valor
    header("Location: ../Dashboard/dashboard.php"); // redirige al usuario a la página del administrador
    exit();
}

// todas las importaciones
require_once "./components/db_connect.php";
$dateError = $error = '';
$id = $_GET['v'];

// consulta para traer los datos de la base de datos
$sql = "SELECT * FROM `animals` WHERE animal_id = $id";
$result = mysqli_query($connect, $sql);
$layout = "";

if (mysqli_num_rows($result) == 0) {
    $layout .= "<p>No results found</p>";
} else {

    // obtener datos en un ARRAY ASOCIATIVO
    $rows = mysqli_fetch_assoc($result);
}

$sqlU = "SELECT * FROM user WHERE user_id = {$_SESSION["user"]}"; // selecciona los detalles del usuario logueado de la sesión de usuario
$resultU = mysqli_query($connect, $sqlU);
$rowsU = mysqli_fetch_assoc($resultU);

if (isset($_POST["adopt"])) {
    $date = cleanInput($_POST["date"]);
    if (empty($date)) {
        $dateError = "<div class='alert alert-danger' role='alert'>You cannot leave the date empty!</div>";
        $error = true;
    }
    if (!$error) {
        $sqlI = "INSERT INTO `user_animals`(`user_id`, `animal_id`, `adoption_date`) VALUES ('{$rowsU["user_id"]}','{$rows["animal_id"]}','$date')";
        $sqlS = "UPDATE `animals` SET `status`='Adopted' WHERE animal_id = {$rows["animal_id"]}";
        mysqli_query($connect, $sqlS);
        if (mysqli_query($connect, $sqlI)) {
            echo "<div class='alert alert-success' role='alert'>You Adopt {$rows["name"]}</div>";
            header("refresh: 3; url= ../home/home.php");
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error: " . mysqli_error($connect) . "</div>";
        }
    }
}

$layout = "
<!-- Card Start -->
<div class='card mb-4 shadow-sm border-light'>
    <div class='row g-0'>
        <!-- Content Section -->
        <div class='col-md-7 p-4'>
            <div class='card-body'>
                <h4 class='card-title mb-3 text-primary'>You want to Adopt {$rows["name"]}!!! Great!!!</h4>
                <p class='card-text mb-4'>{$rows["description"]}</p>
                <div class='mb-3'>
                    <p class='card-text'><strong>Size:</strong> {$rows["size"]}</p>
                    <p class='card-text'><strong>Age:</strong> {$rows["age"]}</p>
                    <p class='card-text'><strong>Breed:</strong> {$rows["breed"]}</p>
                </div>
                <hr>
                <form method='POST' class='d-flex flex-column flex-md-row align-items-start justify-content-around' enctype='multipart/form-data'>
                    <div class='mb-3 '>
                        <label for='date' class='form-label'>Pick-Up Date:</label>
                        <input type='date' class='form-control' id='date' name='date'>
                        <p class='text-danger mt-2'>{$dateError}</p>
                       
                    </div>
                        <hr/>
                    <button type='submit' name='adopt' class='btn btn-primary mt-3 mt-md-0 ms-md-3'>Adopt</button>
                </form>
            </div>
        </div>
        <!-- Image Section -->
        <div class='col-md-5'>
            <img src='{$rows["photo"]}' class='img-fluid rounded-start my-5' alt=''>
        </div>
    </div>
</div>
<!-- End of card -->
";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .title {
            color: #007bff;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .card {
            border-radius: 10px;
        }

        .card-body {
            background-color: #ffffff;
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="title h1 text-center">You Want to Adopt!!!!?</div>
        <?= $layout ?>
    </div>
</body>

</html>