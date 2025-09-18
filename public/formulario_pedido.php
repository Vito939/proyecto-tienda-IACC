<?php
require_once __DIR__ . '/../src/config/conexion.php';

// Obtener clientes para el dropdown
$sql_clientes = "SELECT id_cliente, nombre FROM CLIENTE";
$resultado_clientes = $conn->query($sql_clientes);

// Obtener productos para el dropdown
$sql_productos = "SELECT id_producto, nombre, precio FROM PRODUCTO";
$resultado_productos = $conn->query($sql_productos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de pedido</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <header>
        <h1>Registrar un nuevo Pedido</h1>
    </header>

    <a href='./index.php' class="nav-link">Volver a la pagina principal</a>

    <div class="pedido-form-container">
        <form action="../src/logic/registrar_pedido.php" method="POST">
            
            <label for="id_cliente">Cliente:</label><br>
            <select id="id_cliente" name="id_cliente" required>
                <option value="">Seleccione un cliente</option>
                <?php
                if ($resultado_clientes->num_rows > 0) {
                    while($fila = $resultado_clientes->fetch_assoc()) {
                        echo "<option value='" . $fila['id_cliente'] . "'>" . htmlspecialchars($fila['nombre']) . "</option>";
                    }
                }
                ?>
            </select><br><br>

            <label for="id_producto">Producto:</label><br>
            <select id="id_producto" name="id_producto" required>
                <option value="">Seleccione un producto</option>
                <?php
                if ($resultado_productos->num_rows > 0) {
                     // Reiniciamos el puntero del resultado por si se usó antes
                    $resultado_productos->data_seek(0);
                    while($fila = $resultado_productos->fetch_assoc()) {
                        echo "<option value='" . $fila['id_producto'] . "' data-precio='" . $fila['precio'] . "'>" . htmlspecialchars($fila['nombre']) . "</option>";
                    }
                }
                ?>
            </select><br><br>

            <label for="cantidad">Cantidad de unidades:</label><br>
            <input type="number" id="cantidad" name="cantidad" min="1" required><br><br>

            <label for="tipo">Tipo de pedido:</label><br>
            <select id="tipo" name="tipo" required>
                <option value="">Seleccione una opción</option>
                <option value="Envio a domicilio">Envío a domicilio</option>
                <option value="Retiro en tienda">Retiro en tienda</option>
            </select><br><br>
            
            <label for="observaciones">Observaciones:</label>
            <textarea id="observaciones" name="observaciones"></textarea><br><br>

            <button type="submit">Realizar Pedido</button>
        </form>
    </div>
</body>
</html>