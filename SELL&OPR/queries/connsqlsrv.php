

<?php
//Usuario
//contraseña
//base
//servidor


$usuario= 'magil';
$pass = 'Marcoo0';
$servidor = '172.25.12.26\BI';
$basedatos = 'dbRoberts';
global $conexion;
$info = array('Database'=>$basedatos, 'UID'=>$usuario, 'PWD'=>$pass);
$conexion =sqlsrv_connect($servidor, $info) or die("no se establecio conexion");


?>


<?php
/*

$servername = "190.92.178.246";
$username = "hholdn4_haberholding";
$database = "hholdn4_haberholding_formularios";
$password = "uGnHJEuoikRf6xYs";
//  Create a new connection to the MySQL database using PDO
global $conn;
$conn = new mysqli($servername,$username,$password,$database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
*/
?>
