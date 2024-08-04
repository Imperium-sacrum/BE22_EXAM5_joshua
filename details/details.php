<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) { // if the session user and the session adm have no value
    header("Location:../login.php"); // redirect the user to the home page
    exit();
}

if (isset($_SESSION["adm"])) {
    $session = $_SESSION["adm"];
    header("Location: ../Dashbord/dashbord.php"); // redirect the user to the home page
    exit();
} else {
    $session = $_SESSION["user"];
}

// all imports
require_once  "../components/db_connect.php";
// require_once "../components/file_upload.php";
// all imports ends


$id = $_GET['v'];

// querry to bring the date of the database
$sql = "SELECT * FROM `animals` WHERE animal_id = $id";
$result = mysqli_query($connect, $sql);
// var_dump($result);
$layout = "";

if (mysqli_num_rows($result) == 0) {
    $layout .= "<p> No results found</p>";
} else {
    # fetching data to ASOCIATIVE ARRAY
    $rows = mysqli_fetch_assoc($result);
}


$sqlU = "SELECT * FROM user WHERE user_id = {$_SESSION["user"]}";
$resultU = mysqli_query($connect, $sqlU);
$rowsU = mysqli_fetch_assoc($resultU);
$userE = "{$rowsU["email"]}";
$userP = "{$rowsU["picture"]}";


if ($rows["vaccinated"] == true) {
    $rows["vaccinated"] = 'Yes';
} else {
    $rows["vaccinated"] = 'No';
}

$layout =
    "
<div class='d-flex m-4'>
  <div>
    <img
      class='border border-2 border-success imgCard2'
      src='../{$rows["photo"]}'
      alt=''
    /> 
  </div>
  <div class='container'>
    <h3>Name:{$rows["name"]}</h3>
    <h6>Breed: {$rows["breed"]}</h6>
        <hr />
    <h5>Age: <p class='btn btn-dark my-1'>{$rows["age"]}</p></h5>
    <p>size: {$rows["size"]}
    <hr />
    <h6>Vaccinated: <button class='link-offset-1' href=''>{$rows["vaccinated"]}</button></h6>
    <p>Location: {$rows["location"]}</p>
    <hr />
    <h4>Description of {$rows["name"]}:</h4>
    <p>{$rows["description"]}</p>
    <hr />
    <div class='d-flex justify-content-between'>
    <div><a class='btn btn-success' href='../adopted.php?v={$rows["animal_id"]}'>Adopt Now!!!</a></div>
    <div class='text-danger d-flex justify-content-center'><h1>{$rows["status"]}</h1></div>
    </div>
    </div>
  </div>
</div>";
mysqli_close($connect); // ends------->
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library | Destails</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
    <link rel="stylesheet" href="./style.css">
</head>
<a href="../adopted.php"></a>

<body>
    <!-- main Navbar for the main page -->
    <nav class="navbar navbar-expand-lg bg-primary navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img class="rounded-5 me-2" style="width: 40px;" src="../images/<?= $userP ?>" alt="User Image">
                <?= $userE ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="../home/home.php" aria-current="page" href="#">Available Pets</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a class="btn btn-danger" href="../logout.php?logout" aria-current="page">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- navbar ends here -->
    <?= $layout ?>
    <div class="">
        <!-- Footer -->
        <footer class="text-center text-white" style="background-color: #000000">
            <!-- Grid container -->
            <div class="container">
                <!-- Section: Links -->
                <section class="mt-5">
                    <!-- Grid row-->
                    <div class="row text-center d-flex justify-content-center pt-5">
                        <!-- Grid column -->
                        <div class="col-md-2">
                            <h6 class="text-uppercase font-weight-bold">
                                <a href="index.php" class="text-white">About us</a>
                            </h6>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-2">
                            <h6 class="text-uppercase font-weight-bold">
                                <a href="index.php" class="text-white">Library</a>
                            </h6>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-2">
                            <h6 class="text-uppercase font-weight-bold">
                                <a href="index.php" class="text-white">Awards</a>
                            </h6>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-2">
                            <h6 class="text-uppercase font-weight-bold">
                                <a href="index.php" class="text-white">Help</a>
                            </h6>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-2">
                            <h6 class="text-uppercase font-weight-bold">
                                <a href="index.php" class="text-white">Contact</a>
                            </h6>
                        </div>
                        <!-- Grid column -->
                    </div>
                    <!-- Grid row-->
                </section>
                <!-- Section: Links -->

                <hr class="my-5" />

                <!-- Section: Text -->
                <section class="mb-5">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-8">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt
                                distinctio earum repellat quaerat voluptatibus placeat nam,
                                commodi optio pariatur est quia magnam eum harum corrupti dicta,
                                aliquam sequi voluptate quas.
                            </p>
                        </div>
                    </div>
                </section>
                <!-- Section: Text -->

                <!-- Section: Social -->
                <section class="text-center mb-5">
                    <a href="" class="text-white me-4">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="" class="text-white me-4">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="" class="text-white me-4">
                        <i class="fab fa-google"></i>
                    </a>
                    <a href="" class="text-white me-4">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="" class="text-white me-4">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="" class="text-white me-4">
                        <i class="fab fa-github"></i>
                    </a>
                </section>
                <!-- Section: Social -->
            </div>
            <!-- Grid container -->

            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
                © 2024 Copyright:
                <a class="text-white">Rauchwerger</a>
            </div>
            <!-- Copyright -->
        </footer>
        <!-- Footer -->
    </div>
    <!-- End of .container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>