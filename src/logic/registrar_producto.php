<?php
require_once __DIR__ . '/../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $precio = $conn->real_escape_string($_POST['precio']);
    $stock = $conn->real_escape_string($_POST['stock']);

    $sql = "INSERT INTO PRODUCTO (nombre, descripcion, precio, stock) VALUES ('$nombre', '$descripcion', '$precio', '$stock')";

    if ($conn->query($sql) === TRUE) {
        header('Location: ../../public/mostrar_datos.php?exito=1');
        exit();
    } else {
        echo "<h1>Error al registrar producto</h1>";
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>