<?php
session_start();
require_once __DIR__ . '/../src/config/conexion.php';

//se elimina el arreglo y se recuperan los datos desde la base de datos
$productos_db = [];
$sql_productos = "SELECT id_producto, nombre, precio FROM PRODUCTO";
$resultado = $conn->query($sql_productos);
if ($resultado && $resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        // Usamos el id_producto como índice para encontrarlo fácilmente después
        $productos_db[$fila['id_producto']] = $fila;
    }
}

// Recuperar el carrito de la sesión
$carrito = (isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])) ? $_SESSION['carrito'] : [];
$total = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Carrito de compras</title>
</head>
<body>
    <header>
        <h1>Carrito de Compras</h1>
    </header>

    <a href="./index.php" class="nav-link">Seguir Comprando</a>

    <div class="carrito-display-container">
        <?php if(empty($carrito)): ?>
            <h3>Tu carrito está vacío.</h3>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrito as $id => $cantidad): ?>
                        <?php
                        
                        if(isset($productos_db[$id])):
                            $producto_encontrado = $productos_db[$id];
                            $subtotal = $producto_encontrado['precio'] * $cantidad;
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto_encontrado['nombre']); ?></td>
                            <td><?php echo (int)$cantidad; ?></td>
                            <td>$<?php echo number_format($producto_encontrado['precio'], 0, ',', '.'); ?></td>
                            <td>$<?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                            <td>
                                <a href="../src/logic/eliminar_producto.php?id=<?php echo urlencode($id); ?>" class="boton-eliminar">Eliminar</a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="total-carrito">
                <h3>Total a pagar: $<?php echo number_format($total, 0, ',', '.'); ?></h3>
            </div>
            <a href="../src/logic/vaciar_carrito.php" class="nav-link">Vaciar Carrito</a>
        <?php endif; ?>
    </div>
</body>
</html>
<?php $conn->close(); ?>

