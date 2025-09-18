<?php
//Mantiene la conexion con la base de datos
//se ingresan los parametros de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "TIENDA";

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>