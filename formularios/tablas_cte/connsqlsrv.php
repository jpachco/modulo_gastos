<?php
//Usuario
//contraseña
//base
//servidor
  $servername = 'localhost';
  $username = 'hholdn4_haberholding';
  $password = 'uGnHJEuoikRf6xYs';
  $database = 'hholdn4_haberholding_formularios';
//  Create a new connection to the MySQL database using PDO
global $conn;
$conn = new mysqli($servername, $username, $password,$database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




?>

