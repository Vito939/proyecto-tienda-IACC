<?php
require_once __DIR__ . '/../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $email = $conn->real_escape_string($_POST['email']);
    $direccion = $conn->real_escape_string($_POST['direccion']);

    $sql = "INSERT INTO CLIENTE (nombre, email, direccion) VALUES ('$nombre', '$email', '$direccion')";

    if ($conn->query($sql) === TRUE) {
        header('Location: ../../public/mostrar_datos.php?exito=1');
        exit();
    } else {
        echo "<h1>Error al registrar al cliente</h1>";
        echo "<p>Error: " . $conn->error . "</p>";
    }
    $conn->close();
}
