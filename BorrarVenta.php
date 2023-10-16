<?php
include './venta.php';
function borrarVenta($rutaOrigen, $rutaEliminada){
    if(!isset($_POST["pedido"])){
        echo 'Error. Faltan parametros para la eliminacion de venta';
    }else{
        $pedido = $_POST["pedido"];
        if(Venta::VentaExiste($pedido)){
            Venta::BorrarVenta($pedido, $rutaOrigen, $rutaEliminada);
        }else{
            echo 'No se pudo borrar la venta porque no existe';
        }
    }
}
?>