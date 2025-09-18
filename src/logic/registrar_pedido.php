<?php
require_once __DIR__ . '/../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Obtener y sanitizar datos del formulario
    $id_cliente = (int)$_POST['id_cliente'];
    $id_producto = (int)$_POST['id_producto'];
    $cantidad = (int)$_POST['cantidad'];
    $tipo_pedido = $conn->real_escape_string($_POST['tipo']);
    $observaciones = $conn->real_escape_string($_POST['observaciones']);

    // 2. Obtener el precio del producto desde la BD para seguridad
    $sql_precio = "SELECT precio FROM PRODUCTO WHERE id_producto = $id_producto";
    $resultado_precio = $conn->query($sql_precio);
    if ($resultado_precio->num_rows > 0) {
        $precio_unitario = $resultado_precio->fetch_assoc()['precio'];
    } else {
        die("Error: Producto no encontrado.");
    }

    // Iniciar una transacción para asegurar que ambas inserciones se completen
    $conn->begin_transaction();

    try {
        // 3. Insertar en la tabla PEDIDO
        $sql_pedido = "INSERT INTO PEDIDO (id_cliente, tipo_pedido, observaciones) VALUES (?, ?, ?)";
        $stmt_pedido = $conn->prepare($sql_pedido);
        $stmt_pedido->bind_param("iss", $id_cliente, $tipo_pedido, $observaciones);
        $stmt_pedido->execute();

        // 4. Obtener el ID del pedido recién creado
        $id_pedido_nuevo = $conn->insert_id;

        // 5. Insertar en la tabla DETALLE_PEDIDO
        $sql_detalle = "INSERT INTO DETALLE_PEDIDO (id_pedido, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
        $stmt_detalle = $conn->prepare($sql_detalle);
        $stmt_detalle->bind_param("iiid", $id_pedido_nuevo, $id_producto, $cantidad, $precio_unitario);
        $stmt_detalle->execute();
        
        // Si todo fue bien, confirmar los cambios
        $conn->commit();

        echo "<h1>¡Pedido registrado con éxito!</h1>";
        echo "<p>El pedido con ID <strong>$id_pedido_nuevo</strong> ha sido creado correctamente.</p>";
        echo "<a href='../../public/index.php' class='nav-link'>Volver a la página principal</a>";

    } catch (mysqli_sql_exception $exception) {
        // Si algo falló, revertir los cambios
        $conn->rollback();
        echo "<h1>Error al registrar el pedido.</h1>";
        echo "<p>Ocurrió un error: " . $exception->getMessage() . "</p>";
    }

    $conn->close();

} else {
    // Si no es por POST, redirigimos al formulario.
    header('Location: ../../public/formulario_pedido.php');
    exit();
}
?>