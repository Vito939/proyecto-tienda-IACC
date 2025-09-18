<?php
session_start();
require_once __DIR__ . '/../src/config/conexion.php';
#Semana 6: se elimina array de productos y se agregan a la base de datos
#Obtener productos de la base de datos
$sql = "SELECT id_producto, nombre, descripcion, precio, stock, imagen_url FROM PRODUCTO";
$resultado = $conn->query($sql);

$productos_db = [];
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $productos_db[] = $fila;
    }
}

$sql_reseñas = "SELECT id_producto, calificacion, comentario, fecha_reseña FROM RESEÑA ORDER BY fecha_reseña DESC";
$resultado_reseñas = $conn->query($sql_reseñas);
$reseñas_por_producto = [];
if ($resultado_reseñas && $resultado_reseñas->num_rows > 0) {
    while ($fila = $resultado_reseñas->fetch_assoc()) {
        $reseñas_por_producto[$fila['id_producto']][] = $fila;
    }
}
$items_en_carrito = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Tienda de comercio Electrónico</title>
</head>
<body>
    <header>
        <div class="header-center-container">
            <div class="header-panel">
                <h1>Tienda de Comercio Electrónico</h1>
                <div id="estado-carrito"><h4>Carrito: <?php echo $items_en_carrito; ?> items</h4></div>
                <a href="./mostrar_carrito.php" class="nav-link">Ver carrito</a>
                <a href="formulario_pedido.php" class="nav-link">Crear un nuevo pedido</a>
                <a href="buscar_pedido.html" class="nav-link">Buscar pedido</a>
            </div>
            <div class="header-panel" style="margin-left: 40px;">
                <hr>
                <h3>Panel de Administración</h3>
                <a href="mostrar_datos.php" class="nav-link" style="background-color: #007bff;">Ver Datos Registrados</a>
                <a href="clientes_frecuentes.php" class="nav-link" style="background-color: #28a745;">Clientes Frecuentes</a>
            </div>
        </div>
    </header>

    <div class="busqueda-container">
        <input type="text" id="producto-search" placeholder="Buscar producto">
        <button id="busqueda-button">Buscar</button>
    </div>

    <div id="productos-container">
        <h3>Nuestros Productos</h3>
        <div class="productos-grid">
            <?php foreach ($productos_db as $producto): ?>
                <div class="producto">
                    <img src="img/<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                    <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                    <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <p>Precio: $<?php echo number_format($producto['precio'], 0, ',', '.'); ?></p>

                    <a href="../src/logic/agregar_carrito.php?id=<?php echo $producto['id_producto']; ?>" class="boton-agregar">Agregar al carrito</a>
                    <div class="reseña-container">
                        <h4>Dejar reseña</h4>
                        <form action="../src/logic/guardar_reseña.php" method="POST">
                            <input type="hidden" name="producto_id" value="<?php echo $producto['id_producto']; ?>">
                            <input type="hidden" name="producto_nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
                            <select name="calificacion" required>
                                <option value="">---Califica el producto---</option>
                                <option value="5">★★★★★</option>
                                <option value="4">★★★★☆</option>
                                <option value="3">★★★☆☆</option>
                                <option value="2">★★☆☆☆</option>
                                <option value="1">★☆☆☆☆</option>
                            </select>
                            <br>
                            <textarea name="reseña" rows="3" placeholder="Tu opinión..." required></textarea>
                            <br>
                            <button type="submit">Enviar</button>
                        </form>
                        <div class="reseñas-existentes">
                            <h4>Opiniones de otros usuarios:</h4>
                            <?php
                            if (isset($reseñas_por_producto[$producto['id_producto']])):
                                foreach ($reseñas_por_producto[$producto['id_producto']] as $reseña):
                            ?>
                                    <div class="reseña-individual">
                                        <strong>Calificación: <?php echo str_repeat('★', $reseña['calificacion']) . str_repeat('☆', 5 - $reseña['calificacion']); ?></strong>
                                        <p><?php echo htmlspecialchars($reseña['comentario']); ?></p>
                                        <small><?php echo date('d/m/Y', strtotime($reseña['fecha_reseña'])); ?></small>
                                    </div>
                            <?php
                                endforeach;
                            else:
                                echo "<p>Este producto aún no tiene reseñas. ¡Sé el primero!</p>";
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="resultados-container">
        <!-- Contenedor con los resultados de búsqueda -->
    </div>
    <div id="notificacion-container"></div>
    <script>
        /* Pasar productos de PHP a JavaScript */
        const productos = <?php echo json_encode($productos_db); ?>;
    </script>
    
    <script src="js/main.js"></script>
</body>
</html>