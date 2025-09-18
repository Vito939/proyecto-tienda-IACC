<?php
session_start();
//se recupera el id desde la url
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $producto_id = (int)$_GET['id'];

    //Si el carrito no existe, se crea un array vacío
    if(!isset($_SESSION['carrito'])){
        $_SESSION['carrito'] = [];
    }

    //Logica para agregar productos
    if(isset($_SESSION['carrito'][$producto_id])){
        $_SESSION['carrito'][$producto_id]++; //Si el producto ya está en el carrito, se incrementa la cantidad
    }else{
        $_SESSION['carrito'][$producto_id] = 1; //Si el producto no está en el carrito, se añade 1
    }
}

//Redirigir de vuelta a la página principal
header('Location: ../../public/index.php');
exit();
?>