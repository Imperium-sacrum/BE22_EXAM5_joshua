<?php
// all imports
require_once  "./components/db_connect.php";
require_once "./components/file_upload.php";
// all imports ends

$error = false;
// --------------<
$fname = $lname = $address = $email = $pass = $img = $phone = '';
$fnameError = $lnameError = $addressError = $emailError = $passError = $passError2 = $passError3 = $phoneError = $imgError  = '';
$UpperCase = "text-danger";
$Number = "text-danger";
// ends------->

// btn to register
if (isset($_POST['btn-signup'])) {
  // firstName
  $fname = cleanInput($_POST['firstName']);
  // lastName
  $lname = cleanInput($_POST['lastName']);
  // dateOfBirth
  $address = cleanInput($_POST['address']);
  // email
  $email = cleanInput($_POST['email']);
  // phone
  $phone = cleanInput($_POST['phoneNumber']);
  // Password
  $pass = cleanInput($_POST['password']);
  // images
  $img = fileUpload($_FILES['photo']);

  // validators for the register-----<
  $error = "";
  // FIRST NAME Validators for the register
  if (empty($fname)) {
    $error = true;
    $fnameError = "first name can't be empty";
  } elseif (strlen($fname) < 3) {
    $error = true;
    $fnameError = "first name can't be least than 2 charts";
  } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fname)) {
    $error = true;
    $fnameError = "first name must contain only letters and spaces";
  }

  // LAST NAME Validators for the register
  if (empty($lname)) {
    $error = true;
    $lnameError = "the Last Name can't be empty";
  } elseif (strlen($lname) < 3) {
    $error = true;
    $lnameError = "the Last Name can't be least than 2 charts";
  } elseif (!preg_match("/^[a-zA-Z\s]+$/", $lname)) {
    $error = true;
    $lnameError = "the Last Name must contain only letters and spaces";
  }
  // address for the register
  if (empty($address)) {
    $error = true;
    $addressError = "the Address can't be empty";
  }

  // Phone Number for the register
  if (empty($phone)) {
    $error = true;
    $phoneError = "the Phone Number can't be empty";
  }


  // EMAIL Validators for the register 
  if (empty($email)) {
    $error = true;
    $emailError = "the Email can't be empty";
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // if the provided text is not a format of an email, error will be true
    $error = true;
    $emailError = "Please enter a valid email address";
  } else {
    // if email is already exists in the database, error will be true
    $query = "SELECT email FROM user WHERE email='$email'";
    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) != 0) {
      $error = true;
      $emailError = "Provided Email is already in use or maybe you already have an account <br>The you want to try? <a href='login.php'>Login</a>";
    }
  }
  // Verify if the email is in a valid format
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $dominio = substr(strrchr($email, "@"), 1);
    $allowedDominios = array("gmail.com", "hotmail.com", "gmx.at");
    if (!in_array($dominio, $allowedDominios)) {
      $error = true;
      $allowed = implode(", ", $allowedDominios); # join(", ")
      $emailError = "that domain is not accepted, we only accept (" . $allowed . ")";
    }
  }

  // PASSWORD Validators for the register
  // simple validation for the "password"
  if (empty($pass)) {
    $error = true;
    $passError = "Password can't be empty!";
  } elseif (strlen($pass) < 8) {
    $error = true;
    $passError = "Password must have at least 8 characters.";
  }

  // if to check if the password is missing a number, capital letter or special characters
  if (strlen($pass) >= 8) {
    // $regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
    $capital = preg_match('/[A-Z]/', $pass);
    $hatNumber = preg_match('/\d/', $pass);
    // $special = preg_match($regex, $pass);
    if (!$capital) {
      $passError = "Password must have at least 1 Capital letter, one small letter, number and a special char";
    }
    if (!$hatNumber) {
      $passError2 = "Password must have at least 1 Number.";
    }
  }



  if (!$error) { // if there is no error with any input, data will be inserted to the database
    // hashing the password before inserting it to the database
    $password = hash("sha256", $pass);

    $sql = "INSERT INTO user (`first_name`, `last_name`, `email`, `phone_number`, `address`, `picture`, `password`, `status`) VALUES ('$fname','$lname', '$email',$phone, '$address', '$img[0]', '$password', 'user')";

    $result = mysqli_query($connect, $sql);

    if ($result) {
      echo "<div class='alert alert-success'>
            <p>New account has been created, $img[1]</p>
        </div>";
      header("refresh: 3; url= login.php");; // users will be redirected to login.php page
    } else {
      echo "<div class='alert alert-danger'>
            <p>Something went wrong, please try again later ...</p>
        </div>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link rel="stylesheet" href="./styleRegister.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-2-strong card-registration" style="border-radius: 15px">
      <div class="card-body p-4 p-md-5">
        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registration Form</h3>
        <form method="post" autocomplete="off" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6 mb-4">
              <div class="form-outline">
                <p class="text-danger"><?= $fnameError ?></p>
                <input type="text" id="firstName" name="firstName" value="<?= $fname ?>" class="form-control form-control-lg" />
                <label class="form-label" for="firstName">First Name</label>
              </div>
            </div>
            <div class="col-md-6 mb-4">
              <div class="form-outline">
                <p class="text-danger"><?= $lnameError ?></p>
                <input type="text" id="lastName" name="lastName" value="<?= $lname ?>" class="form-control form-control-lg" />
                <label class="form-label" for="lastName">Last Name</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-4">
              <div class="form-outline">
                <p class="text-danger"><?= $addressError ?></p>
                <input type="text" class="form-control form-control-lg" value="<?= $address ?>" name="address" id="address" />
                <label for="address" class="form-label">Address</label>
              </div>
            </div>
            <div class="col-md-6 mb-4">
              <div class="form-outline">
                <p class="text-danger"><?= $emailError ?></p>
                <input type="email" id="email" name="email" value="<?= $email ?>" class="form-control form-control-lg" />
                <label class="form-label" for="email">Email</label>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center gap-2 ">
            <div class="col-md-6 mb-4">
              <div class="form-outline">
                <p class="text-danger"><?= $phoneError ?></p>
                <input type="number" id="phoneNumber" name="phoneNumber" value="<?= $phone ?>" class="form-control form-control-lg" />
                <label class="form-label" for="phoneNumber">Phone Number</label>
              </div>
            </div>
            <div class="col-md-6 mb-4 file-input-container my-1">
              <input class="form-control " name="photo" type="file" id="photo">
              <label for="photo" class="form-label">Profile Photo</label>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-4">
              <div class="form-outline">
                <p class="text-danger"><?= $passError ?> <?= $passError2 ?></p>
                <input type="password" class="form-control form-control-lg" name="password" id="password" />
                <label for="password" class="form-label">Password</label>
              </div>
            </div>
          </div>

          <div class="mt-4 pt-2">
            <input data-mdb-ripple-init class="btn btn-primary btn-lg w-100" name="btn-signup" type="submit" value="Submit" />
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>