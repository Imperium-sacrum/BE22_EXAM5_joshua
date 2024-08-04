<?php
// <!-- php script -->
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) { // if the session user and the session adm have no value
  header("Location: ../login.php"); // redirect the user to the home page
  exit();
}
if (isset($_SESSION["user"])) { // if a session "user" is exist and have a value
  header("Location: ../home/home.php"); // redirect the user to the user page
  exit();
}
// all imports
require_once  "../components/db_connect.php";
  // require_once "./crud-class.php"
  // all imports ends
;

// $obj = new CRUD();
$name = $lname = $date_of_birth = $email = $pass = $img = $ava = $optionsP = $optionsS = $optionsA = $optionsT = '';

// query to bring data like books, CD and DVD from the database------<
$sql = "SELECT * FROM `animals`";
$result = mysqli_query($connect, $sql);
if (mysqli_num_rows($result) == 0) {
  $layout .= "<p class='text-white'> No results found</p>";
} else {
  # fetching data to ASOCIATIVE ARRAY
  $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
}



// ends-------------->

// // query to bring data of user or admin from the database------<
$sqlU = "SELECT * FROM user WHERE user_id = {$_SESSION["adm"]}"; // selecting logged-in user details from the session user
$resultU = mysqli_query($connect, $sqlU);
$rowsU = mysqli_fetch_assoc($resultU);
$userOrAdmin = "
<div class='d-flex'>
    <div class='border border-2 rounded-circle border-light'>
        <img style='width: 45px; height: 45px' class='rounded-circle' src='../images/{$rowsU["picture"]}'' alt=''>
    </div>
    <div>
        hello, {$rowsU["first_name"]}
    </div>
</div>";

// ends-------------------->

$layout = "";
foreach ($rows as $row) {
  if ($row["status"] == "Available") {
    $ava = "<p class='border border-success w-75 text-success text-center'>AVAILABLE</p>";
  } else {
    $ava = "<p class='border border-danger text-danger w-75 text-Danger text-center'>Adopted</p>";
  }
  if ($row["vaccinated"] == true) {
    $row["vaccinated"] = "Yes";
  } else {
    $row["vaccinated"] = "No";
  }

  $layout .= "
<table class='table align-middle mb-0 bg-white'>
  <thead class='bg-light'>
    <tr>
        <th class='w-25'>Name And Breed</th>
        <th>Age And Vaccination</th>
        <th>Location</th>
        <th>Description</th>
        <th >Available</th>
        <th class='text-center'>Actions</th>
    </tr>
  </thead>
  <tbody >
    <tr >
      <td class='py-4'>
            <div class='d-flex align-items-center'>
                <img
                    src='../{$row["photo"]}'
                    alt=''
                    style='width: 60px; height: 60px'
                    class='rounded-circle'
                    />
            <div class='ms-3'>
                <p class='fw-bold mb-1'>{$row["name"]}</p>
                <p class='text-muted mb-0'>Breed: {$row["breed"]}</p>
            </div>
            </div>
        </td>
        <td>
            <p class='fw-normal mb-1'>Age: {$row["age"]}</p>
            <p class='text-muted mb-0'>Vaccinated: {$row["vaccinated"]}</p>
        </td>
        <td style='width: 30vh;'>
            <span class='badge badge-success text-black rounded-pill d-inline'>{$row["location"]}</span>
        </td>
        <td  style='width: 30vh;'>
            {$row["description"]}
        </td>
        <td>
            $ava
        </td>
        <td class='text-center'>
            <button type='button' name='created' class='btn btn-success btn-lg btn-floating' data-mdb-ripple-init>
              <a href='../animal-crud/created.php' class='text-black'><i class='fa-solid fa-plus'></i></a>
            </button>
            <button type='button' class='btn btn-outline-warning btn-lg btn-floating' data-mdb-ripple-init data-mdb-ripple-color='dark'>
              <a href='../animal-crud/update.php?v={$row["animal_id"]}' class='text-primary'><i class='fa-solid fa-pen'></i></a>
            </button>
            <button type='button' class='btn btn-danger btn-lg btn-floating' data-mdb-ripple-init>
              <a href='../animal-crud/deleted.php?v={$row["animal_id"]}' class='text-black'><i class='fa-solid fa-trash'></i></a>
            </button>
        </td>
    </tr>";
}
mysqli_close($connect); // ends------->
?>

<!-- html beginns -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pet Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./style.css">
</head>

<body class="bg-dark">
  <!-- main Navbar for the main page -->
  <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body border-botton border-white border-3" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="./dashboard.php">Dashbord</a>
      <button class=" navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" href="./dashboard.php" aria-current="page">Animals</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="./dashboard-user.php" aria-current="page">Users</a>
          </li>

        </ul>
        <h6 class="text-white my-2 mx-5"><?= $userOrAdmin ?></h6>
        <a class="btn btn-danger" href="../logout.php?logout" aria-current="page">Logout</a>
        <!-- search form -->
      </div>
    </div>
  </nav>
  <!-- href="search.php?p=<//?= $val ?> -->
  <!-- navbar ends here -->


  <div class="w-100% border">
    <?= $layout ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/5076860948.js" crossorigin="anonymous"></script>

</body>

</html>