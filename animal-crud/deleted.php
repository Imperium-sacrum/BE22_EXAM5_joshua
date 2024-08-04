<?php
session_start(); // Start the session

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

// Include connection and file upload components
require_once "../components/db_connect.php";
require_once "../components/file_upload.php";

// Verify and sanitize the id parameter
if (isset($_GET['v']) && is_numeric($_GET['v'])) {
    $id = intval($_GET['v']); // Convert to integer

    // Prepare the query to select the animal
    $sql = "SELECT * FROM animals WHERE animal_id = $id";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Delete the photo if it's not the default photo and not a directory
        if ($row["photo"] != "user.jpg") {
            $photoPath = "../images/{$row["photo"]}";
            if (is_file($photoPath)) {
                unlink($photoPath);
            }
        }

        // Prepare the query to delete the animal
        $sqlDelete = "DELETE FROM animals WHERE animal_id = $id";
        $resultDelete = mysqli_query($connect, $sqlDelete);

        if ($resultDelete) {
            header("Location: ../Dashboard/dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            echo "Error: Could not delete the animal.";
        }
    } else {
        echo "Error: Animal not found.";
    }
} else {
    echo "Error: Invalid parameter.";
}

// Close the database connection
mysqli_close($connect);
