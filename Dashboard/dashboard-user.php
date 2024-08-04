<?php
// Start the session
session_start();

// Redirect to login if no user or admin session is set
if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: ../login.php"); // Redirect to login
    exit();
}

// Redirect to home page if user session is set
if (isset($_SESSION["user"])) {
    header("Location: ../home/home.php"); // Redirect to user home page
    exit();
}

// Include connection and CRUD class files
require_once "../components/db_connect.php";

// Instantiate CRUD object

// Query to get the admin's data
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

// Query to get all users
$sql = "SELECT * FROM user";
$result = mysqli_query($connect, $sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

$layout = "";
foreach ($rows as $row) {
    $layout .= "
<table class='table align-middle mb-0 bg-white'>
  <thead class='bg-light'>
    <tr>
        <th class='w-25'>Name And Photo</th>
        <th>Address and Email</th>
        <th>Phone Number</th>
        <th>User ID</th>
        <th>Status</th>
        <th class='text-center'>Actions</th>
    </tr>
  </thead>
  <tbody>;
    <tr>
      <td>
            <div class='d-flex align-items-center'>
                <img
                    src='../images/{$row["picture"]}'
                    alt=''
                    style='width: 45px; height: 45px'
                    class='rounded-circle'
                    />
            <div class='ms-3'>
                <p class='fw-bold mb-1'>First Name: {$row["first_name"]}</p>
                <p class='text-muted mb-0'>Last Name: {$row["last_name"]}</p>
            </div>
            </div>
        </td>
        <td>
            <p class='fw-normal mb-1'>{$row["address"]}</p>
            <p class='text-muted mb-0'>Email: {$row["email"]}</p>
        </td>
        <td>
            <span class='badge badge-success text-black rounded-pill d-inline'>{$row["phone_number"]}</span>
        </td>
        <td>
            {$row["user_id"]}
        </td>
        <td>
            {$row["status"]}
        </td>
        <td class='text-center'>
            <button type='button' name='created' class='btn btn-primary btn-lg btn-floating' data-mdb-ripple-init>
              <i class='fa-solid fa-plus'></i>
            </button>
            <button type='button' class='btn btn-outline-success btn-lg btn-floating' data-mdb-ripple-init data-mdb-ripple-color='dark'>
              <i class='fa-solid fa-pen'></i>
            </button>
            <button type='button' class='btn btn-danger btn-lg btn-floating' data-mdb-ripple-init>
              <i class='fa-solid fa-trash'></i>
            </button>
        </td>
    </tr>;
  </tbody>
</table>";
}
mysqli_close($connect); // Close the database connection
?>

<!-- html begins -->
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
    <!-- Main Navbar for the main page -->
    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body border-bottom border-white border-3" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="./dashboard.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                <!-- Search form -->
            </div>
        </div>
    </nav>
    <!-- Navbar ends here -->

    <div class="w-100% border">
        <?= $layout ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/5076860948.js" crossorigin="anonymous"></script>

</body>

</html>