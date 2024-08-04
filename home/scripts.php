<?php
session_start();
if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) { // if the session user and the session adm have no value
    header("Location: ../register-login/login.php"); // redirect the user to the home page
    exit();
}

// if (isset($_SESSION["adm"])) {
//     $session = $_SESSION["adm"];
//     header("Location: ../Dashbord/dashbord.php"); // redirect the user to the home page
//     exit();
// } else {
//     $session = $_SESSION["user"];
//     header("Location: ../home/home.php"); // redirect the user to the home page
//     exit();
// }

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');

// Define the response function
function response($status, $status_message, $data = null)
{
    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;
    echo json_encode($response);
}

// Connect to the database
require_once "../components/db_connect.php";

$sql = "SELECT * FROM animals";
$result = mysqli_query($connect, $sql);


// ends------->


if (!$result) {
    response(500, "SQL Error: " . mysqli_error($connect));
} elseif (mysqli_num_rows($result) == 0) {
    response(200, "No animals found");
} else {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    response(200, "Animals found", $rows);
}
