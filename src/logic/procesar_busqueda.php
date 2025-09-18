<?php
require_once __DIR__ . '/../config/conexion.php';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <title>Resultados de Búsqueda de Pedidos</title>
    <link rel='stylesheet' href='../../public/css/styles.css'>
</head>
<body>
    <header>
        <h1>Resultados de Búsqueda</h1>
    </header>
    <a href='../../public/buscar_pedido.html' class='nav-link'>Realizar otra búsqueda</a>
    <div class='tablas-flex-container'>
        <div class='tabla-datos-container'>";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['termino_busqueda'])) {
    $termino = "%" . trim($_POST['termino_busqueda']) . "%";
    echo "<h2>Resultados para: '" . htmlspecialchars(trim($_POST['termino_busqueda'])) . "'</h2>";

    // Consulta SQL que une las tablas para obtener toda la información
    $sql = "SELECT
                p.id_pedido,
                p.fecha_pedido,
                c.nombre AS nombre_cliente,
                prod.nombre AS nombre_producto,
                dp.cantidad,
                p.observaciones
            FROM PEDIDO p
            JOIN CLIENTE c ON p.id_cliente = c.id_cliente
            JOIN DETALLE_PEDIDO dp ON p.id_pedido = dp.id_pedido
            JOIN PRODUCTO prod ON dp.id_producto = prod.id_producto
            WHERE c.nombre LIKE ? OR prod.nombre LIKE ? OR p.observaciones LIKE ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $termino, $termino, $termino);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>";
        while($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                    <td>" . $fila['id_pedido'] . "</td>
                    <td>" . $fila['fecha_pedido'] . "</td>
                    <td>" . htmlspecialchars($fila['nombre_cliente']) . "</td>
                    <td>" . htmlspecialchars($fila['nombre_producto']) . "</td>
                    <td>" . $fila['cantidad'] . "</td>
                    <td>" . htmlspecialchars($fila['observaciones']) . "</td>
                </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<h3>No se encontraron pedidos que coincidan con la búsqueda.</h3>";
    }
    $stmt->close();
} else {
    echo "<h3>Por favor, ingresa un término de búsqueda.</h3>";
}

echo "</div></div></body></html>";
$conn->close();
?>