<?php
session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Datos Registrados</title>
</head>
<body>
    <header>
        <h1>Contenido de la Base de Datos TIENDA</h1>
    </header>
    <a href='./index.php' class="nav-link">Volver a la página principal</a>

    <div class="tablas-flex-container">
        <div class="tabla-datos-container">
            <h2>Tabla: PRODUCTO</h2>
            <a href="formulario_producto.html" class="nav-link" style="background-color:#5a0099;">Añadir Producto</a>
            <?php
            require_once __DIR__ . '/../src/config/conexion.php';
            $sql_productos = "SELECT id_producto, nombre, descripcion, precio, stock FROM PRODUCTO";
            $resultado_productos = $conn->query($sql_productos);
            if ($resultado_productos->num_rows > 0) {
                echo "<table>
                <thead>
                <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
                </tr>
                </thead>
                <tbody>";
                while($fila = $resultado_productos->fetch_assoc()) {
                    echo "<tr><td>" . $fila["id_producto"] . "</td>
                    <td>" . htmlspecialchars($fila["nombre"]) . "</td>
                    <td>" . htmlspecialchars($fila["descripcion"]) . "</td>
                    <td>$" . number_format($fila["precio"], 0, ',', '.') . "</td>
                    <td>" . $fila["stock"] . "</td>";
                    echo "<td>
                        <form action='../src/logic/borrar_producto.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='id_producto' value='" . $fila["id_producto"] . "'>
                            <button type='submit' onclick=\"return confirm('¿Eliminar este producto?');\">Eliminar</button>
                        </form>
                    </td></tr>";
                }
                echo "</tbody></table>";
            } else { echo "<h3>No hay productos registrados.</h3>"; }
            ?>
        </div>

        <div class="tabla-datos-container">
            <h2>Tabla: CLIENTE</h2>
            <a href="formulario_clientes.html" class="nav-link" style="background-color:#5a0099;">Añadir Cliente</a>
            <?php
            $sql_clientes = "SELECT id_cliente, nombre, email, direccion FROM CLIENTE";
            $resultado_clientes = $conn->query($sql_clientes);
            if ($resultado_clientes->num_rows > 0) {
                echo "<table>
                <thead>
                <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Acciones</th>
                </tr>
                </thead>
                <tbody>";
                while($fila = $resultado_clientes->fetch_assoc()) {
                    echo "<tr><td>" . $fila["id_cliente"] . "</td>
                    <td>" . htmlspecialchars($fila["nombre"]) . "</td>
                    <td>" . htmlspecialchars($fila["email"]) . "</td>
                    <td>" . htmlspecialchars($fila["direccion"]) . "</td>";
                    echo "<td>
                        <form action='../src/logic/eliminar_cliente.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='id_cliente' value='" . $fila["id_cliente"] . "'>
                            <button type='submit' onclick=\"return confirm('¿Eliminar este cliente?');\">Eliminar</button>
                        </form>
                    </td></tr>";
                }
                echo "</tbody></table>";
            } else { echo "<h3>No hay clientes registrados.</h3>"; }
            ?>
        </div>
        
        <div class="tabla-datos-container">
            <h2>Tabla: COMPRA</h2>
            <?php
            $sql_compras = "SELECT id_compra, id_cliente, id_producto, cantidad, total, fecha FROM COMPRA";
            $resultado_compras = $conn->query($sql_compras);
            if ($resultado_compras->num_rows > 0) {
                echo "<table>
                <thead>
                <tr>
                <th>ID Compra</th>
                <th>ID Cliente</th>
                <th>ID Producto</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Fecha</th>
                </tr>
                </thead>
                <tbody>";
                while($fila = $resultado_compras->fetch_assoc()) {
                    echo "<tr><td>" . $fila["id_compra"] . "</td><td>" . $fila["id_cliente"] . "</td><td>" . $fila["id_producto"] . "</td><td>" . $fila["cantidad"] . "</td><td>$" . number_format($fila["total"], 0, ',', '.') . "</td><td>" . $fila["fecha"] . "</td></tr>";
                }
                echo "</tbody></table>";
            } else { echo "<h3>No hay compras registradas.</h3>"; }
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>