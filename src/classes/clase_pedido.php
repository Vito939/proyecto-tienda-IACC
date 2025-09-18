<?php
class Pedido {
    // Se declaran las propiedades
    public $descripcion_pedido;
    public $tipo_pedido;
    public $producto;
    public $unidades;
    public $observaciones;

    // Método constructor
    public function __construct($descripcion, $tipo, $producto, $unidades, $obs) {
        $this->descripcion_pedido = $descripcion;
        $this->tipo_pedido = $tipo;
        $this->producto = $producto;
        $this->unidades = $unidades;
        $this->observaciones = $obs;
    }

    // Mostrar detalles del pedido
    public function mostrarDetalles() {
        echo "<h2>Detalle del pedido</h2>";
        echo "<ul>";
        echo "<li>Descripción: " . htmlspecialchars($this->descripcion_pedido) . "</li>";
        echo "<li>Tipo de pedido: " . htmlspecialchars($this->tipo_pedido) . "</li>";
        echo "<li>Producto: " . htmlspecialchars($this->producto) . "</li>";
        echo "<li>Unidades: " . htmlspecialchars($this->unidades) . "</li>";
        echo "<li>Observaciones: " . htmlspecialchars($this->observaciones) . "</li>";
        echo "</ul>";
    }

    // Buscar por descripción
    public function buscarPorDescripcion($termino) {
        if (stristr($this->descripcion_pedido, $termino)) {
            echo "<p>Pedido encontrado, coincide con '<b>" . htmlspecialchars($termino) . "</b>'.</p>";
            $this->mostrarDetalles();
            return true;
        }
        return false;
    }
}
?>