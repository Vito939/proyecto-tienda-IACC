<?php
session_start();

//verifica que se envie la id por el URL con GET
if(isset($_GET['id'])) {
    $producto_id = $_GET['id'];
    //Si el producto existe en el carrito, se elimina
    if (isset($_SESSION['carrito'][$producto_id])) {
        unset($_SESSION['carrito'][$producto_id]);
    }
}

// Redirigir de vuelta a la página del carrito
header('Location: ../../public/mostrar_carrito.php');
exit();