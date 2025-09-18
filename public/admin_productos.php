<?php
// admin_productos.php
// Página de administración para añadir y eliminar productos
session_start();


require_once '../src/config/conexion.php';

// Obtener productos de la base de datos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Productos</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Administración de Productos</h1>
    <a href="formulario_producto.html">Añadir Producto</a>
    <table border="1" cellpadding="8" style="margin-top:20px;">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $row['precio']; ?></td>
            <td>
                <form action="../src/logic/eliminar_producto.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
