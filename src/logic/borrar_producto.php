<?php
require_once __DIR__ . '/../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $id_producto = (int)$_POST['id_producto'];

    // Iniciar una transacción para asegurar la integridad
    $conn->begin_transaction();

    try {
        // 1. Eliminar las dependencias en la tabla COMPRA
        $sql_compra = "DELETE FROM COMPRA WHERE id_producto = ?";
        $stmt_compra = $conn->prepare($sql_compra);
        $stmt_compra->bind_param("i", $id_producto);
        $stmt_compra->execute();
        $stmt_compra->close();

        // 2. Eliminar las dependencias en la tabla DETALLE_PEDIDO
        $sql_detalle = "DELETE FROM DETALLE_PEDIDO WHERE id_producto = ?";
        $stmt_detalle = $conn->prepare($sql_detalle);
        $stmt_detalle->bind_param("i", $id_producto);
        $stmt_detalle->execute();
        $stmt_detalle->close();

        // 3. Finalmente, eliminar el producto de la tabla PRODUCTO
        $sql_producto = "DELETE FROM PRODUCTO WHERE id_producto = ?";
        $stmt_producto = $conn->prepare($sql_producto);
        $stmt_producto->bind_param("i", $id_producto);
        $stmt_producto->execute();
        $stmt_producto->close();
        
        // Confirmar los cambios si todo ha ido bien
        $conn->commit();

    } catch (mysqli_sql_exception $exception) {
        // Revertir todos los cambios si algo falla
        $conn->rollback();
        die("Error al eliminar el producto: " . $exception->getMessage());
    }

    $conn->close();
}

// Redirigir de vuelta a la página de datos
header('Location: ../../public/mostrar_datos.php');
exit();
?>