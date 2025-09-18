<?php
require_once __DIR__ . '/../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_cliente'])) {
    $id_cliente = (int)$_POST['id_cliente'];

    // Iniciar una transacción para asegurar la integridad de los datos
    $conn->begin_transaction();

    try {
        // Antes de eliminar el cliente, es una buena práctica eliminar los registros dependientes
        // para evitar errores de clave foránea (foreign key).
        
        // 1. Eliminar detalles de pedidos asociados al cliente (a través de los pedidos)
        $sql_delete_detalles = "DELETE dp FROM DETALLE_PEDIDO dp JOIN PEDIDO p ON dp.id_pedido = p.id_pedido WHERE p.id_cliente = ?";
        $stmt_detalles = $conn->prepare($sql_delete_detalles);
        $stmt_detalles->bind_param("i", $id_cliente);
        $stmt_detalles->execute();
        $stmt_detalles->close();

        // 2. Eliminar los pedidos del cliente
        $sql_delete_pedidos = "DELETE FROM PEDIDO WHERE id_cliente = ?";
        $stmt_pedidos = $conn->prepare($sql_delete_pedidos);
        $stmt_pedidos->bind_param("i", $id_cliente);
        $stmt_pedidos->execute();
        $stmt_pedidos->close();

        // 3. Eliminar las compras del cliente
        $sql_delete_compras = "DELETE FROM COMPRA WHERE id_cliente = ?";
        $stmt_compras = $conn->prepare($sql_delete_compras);
        $stmt_compras->bind_param("i", $id_cliente);
        $stmt_compras->execute();
        $stmt_compras->close();
        
        // 4. Ahora, eliminar el cliente
        $sql_cliente = "DELETE FROM CLIENTE WHERE id_cliente = ?";
        $stmt_cliente = $conn->prepare($sql_cliente);
        $stmt_cliente->bind_param("i", $id_cliente);
        $stmt_cliente->execute();
        $stmt_cliente->close();
        
        // Si todo se ejecutó correctamente, confirmar la transacción
        $conn->commit();

    } catch (mysqli_sql_exception $exception) {
        // Si algo falla, revertir todos los cambios
        $conn->rollback();
        die("Error al eliminar el cliente: " . $exception->getMessage());
    }

    $conn->close();
}

// Redirigir de vuelta a la página de datos
header('Location: ../../public/mostrar_datos.php');
exit();
?>