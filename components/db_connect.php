<?php

$hostname = "127.0.0.1"; // this is the hostname that you can find in the PhpMyAdmin and you can write "localhost" too
$username = "root"; // be default the userName for the databases is root
$password = ""; // by default there is no password in the databases
$dbname = "be22_exam5_animal_adoption_joshua"; // here we need to write the Database name

// create connection, you need to be aware of the order of the parameters
$connect = new mysqli($hostname, $username, $password, $dbname);

// check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// esta funcion limpiar todo inpud recibido para que no lastime el DB(dataBase)
function cleanInput($input)
{
    $date = trim($input);
    $date = strip_tags($date);
    $date = htmlspecialchars($date);
    return $date;
}
