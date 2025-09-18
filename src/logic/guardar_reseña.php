<?php
require_once __DIR__ . '/../config/conexion.php'; // 1. Conexión a la BD

// Se recuperan y validan los datos del formulario con $_POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Es buena práctica validar que los datos existan
    if (isset($_POST['producto_id'], $_POST['calificacion'], $_POST['reseña'])) {
        
        $id_producto = (int)$_POST['producto_id'];
        $calificacion = (int)$_POST['calificacion'];
        // Usamos real_escape_string para proteger contra inyección SQL en el texto
        $comentario = $conn->real_escape_string($_POST['reseña']);

        // 2. Preparamos y ejecutamos la inserción en la base de datos
        $sql = "INSERT INTO RESEÑA (id_producto, calificacion, comentario) VALUES (?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        // "iis" significa que pasaremos dos enteros (integer) y una cadena (string)
        $stmt->bind_param("iis", $id_producto, $calificacion, $comentario);

        if ($stmt->execute()) {
            // 3. Redirigimos de vuelta al index si todo sale bien
            // Podemos añadir un parámetro para mostrar un mensaje de éxito si queremos
            header('Location: ../../public/index.php?reseña=exito');
            exit();
        } else {
            echo "<h1>Error al guardar la reseña.</h1>";
            echo "<p>Ocurrió un error: " . $stmt->error . "</p>";
        }
        
        $stmt->close();
    } else {
        echo "<h1>Error:</h1>";
        echo "<p>Por favor, completa todos los campos del formulario.</p>";
    }
} else {
    // Redirigir si se intenta acceder al script directamente.
    header('Location: ../../public/index.php');
    exit();
}

$conn->close();
?>

