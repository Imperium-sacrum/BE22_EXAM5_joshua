<?php
session_start();
if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) { // if the session user and the session adm have no value
  header("Location: ../login.php"); // redirect the user to the home page
  exit();
}

if (isset($_SESSION["adm"])) {
  $session = $_SESSION["adm"];
  header("Location: ../Dashbord/dashbord.php"); // redirect the user to the home page
  exit();
} else {
  $session = $_SESSION["user"];
}
require_once "../components/db_connect.php";
$sqlU = "SELECT * FROM user WHERE user_id = {$_SESSION["user"]}";
$resultU = mysqli_query($connect, $sqlU);
$rowsU = mysqli_fetch_assoc($resultU);
$userE = "{$rowsU["email"]}";
$userP = "{$rowsU["picture"]}";


if (isset($_POST["adoted"])) {
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="stylesheet" href="./style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
</head>

<body>
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
            <a class="nav-link active" aria-current="page" href="#">Available Pets</a>
          </li>
        </ul>
        <div class="d-flex">
          <a class="btn btn-danger" href="../logout.php?logout" aria-current="page">Logout</a>
        </div>
      </div>
    </div>
  </nav>


  <form class="d-flex justify-content-center my-4">
    <div class="p-3 gap-4 d-flex flex-wrap justify-content-center border border-light rounded">
      <button name="all" id="all" class="btn btn-primary me-2 mb-2">All the Animals</button>
      <button name="senior" id="senior" class="btn btn-primary mb-2">Senior Animals</button>
    </div>
  </form>


  <!-- animals cards -->
  <div class="container d-flex justify-content-center my-2 text-center">
    <div id="cards" class="row row-cols-3-lg row-cols-2-md row-cols-1-sm gap-3"></div>
  </div>

  <div class="">

    <footer class="text-white text-center text-lg-start bg-primary">
      <!-- Grid container -->
      <div class="container p-4">
        <!--Grid row-->
        <div class="row mt-4">
          <!--Grid column-->
          <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
            <h5 class="text-uppercase mb-4">About Pets</h5>

            <p>
              At vero eos et accusamus et iusto odio dignissimos ducimus qui
              blanditiis praesentium voluptatum deleniti atque corrupti.
            </p>


            <p>
              Blanditiis praesentium voluptatum deleniti atque corrupti quos
              dolores et quas molestias.
            </p>

            <div class="mt-4">
              <!-- Facebook -->
              <a type="button" class="btn btn-floating btn-primary btn-lg"><i class="fab fa-facebook-f"></i></a>
              <!-- Dribbble -->
              <a type="button" class="btn btn-floating btn-primary btn-lg"><i class="fab fa-dribbble"></i></a>
              <!-- Twitter -->
              <a type="button" class="btn btn-floating btn-primary btn-lg"><i class="fab fa-twitter"></i></a>
              <!-- Google + -->
              <a type="button" h class="btn btn-floating btn-primary btn-lg"><i class="fab fa-google-plus-g"></i></a>
              <!-- Linkedin -->
            </div>
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase mb-4 pb-1">Search something</h5>

            <div class="form-outline form-white mb-4">
              <input type="text" id="formControlLg" class="form-control form-control-lg" />
              <label class="form-label" for="formControlLg">Search</label>
            </div>

            <ul class="fa-ul" style="margin-left: 1.65em">
              <li class="mb-3">
                <span class="fa-li"><i class="fas fa-home"></i></span><span class="ms-2">New York, NY 10012, US</span>
              </li>
              <li class="mb-3">
                <span class="fa-li"><i class="fas fa-envelope"></i></span><span class="ms-2">info@example.com</span>
              </li>
              <li class="mb-3">
                <span class="fa-li"><i class="fas fa-phone"></i></span><span class="ms-2">+ 01 234 567 88</span>
              </li>
              <li class="mb-3">
                <span class="fa-li"><i class="fas fa-print"></i></span><span class="ms-2">+ 01 234 567 89</span>
              </li>
            </ul>
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase mb-4">Opening hours</h5>

            <table class="table text-center text-white">
              <tbody class="font-weight-normal">
                <tr>
                  <td>Mon - Thu:</td>
                  <td>8am - 9pm</td>
                </tr>
                <tr>
                  <td>Fri - Sat:</td>
                  <td>8am - 1am</td>
                </tr>
                <tr>
                  <td>Sunday:</td>
                  <td>9am - 10pm</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!--Grid column-->
        </div>
        <!--Grid row-->
      </div>
      <!-- Grid container -->

      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        © 2024 Copyright:
        <a class="text-white" href="#">Rauchwerger</a>
      </div>
      <!-- Copyright -->
    </footer>
  </div>
  <!-- End of .container -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/5076860948.js" crossorigin="anonymous"></script>
  <script src="./home-script.js"></script>
</body>

</html>