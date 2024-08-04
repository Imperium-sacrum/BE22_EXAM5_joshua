<?php
session_start();

if (isset($_GET['logout'])) { // if a parameter logout is in the url (?logout)
    unset($_SESSION['user']); // removing the value from the session user
    unset($_SESSION['adm']); // removing the value from the session adm
    session_unset(); // Free all session variables
    session_destroy(); // Deletes all data registered in a session

    header("Location: ./login.php");
}
