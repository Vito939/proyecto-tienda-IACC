<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes Frecuentes</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <header>
        <h1>Clientes frecuentes</h1>
    </header>
    <a href='./index.php' class="nav-link">Volver a la página principal</a>

    <div class="tablas-flex-container">
        <div class="tabla-datos-container">
            <?php
            require_once __DIR__ . '/../src/config/conexion.php';

            // Consulta para obtener clientes con más de 2 compras
            $sql = "SELECT
                        c.nombre,
                        c.email,
                        COUNT(co.id_compra) AS numero_de_compras
                    FROM
                        CLIENTE c
                    JOIN
                        COMPRA co ON c.id_cliente = co.id_cliente
                    GROUP BY
                        c.id_cliente
                    HAVING
                        numero_de_compras > 2";

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                echo "<table>";
                echo "<thead><tr><th>Nombre Cliente</th><th>Email</th><th>N° de Compras</th></tr></thead>";
                echo "<tbody>";
                // fetch_assoc() obtiene una fila de resultados
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>" . $row["numero_de_compras"] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<h3>No se encontraron clientes con más de 2 compras.</h3>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>