<?php
session_start();

//Eliminamos el carrito completo
unset($_SESSION['carrito']);

// Redirigir de vuelta a la página del carrito
header('Location: ../../public/mostrar_carrito.php');
exit();