<?php
include './venta.php';
function modificarVenta(){
    if(!isset($_POST['pedido'], $_POST['mail'], $_POST['sabor'], $_POST['tipo'], $_POST['cantidad']))
    {
        echo "Error. Carga de datos invalida";
    }else{
        $pedido = $_POST['pedido'];
        $mail = $_POST['mail'];
        $sabor = $_POST['sabor'];
        $tipo = $_POST['tipo'];
        $cantidad = $_POST['cantidad'];

        $venta = new Venta($mail, $sabor, $tipo, $cantidad);
        if(Venta::VentaExiste($pedido)){
            Venta::ModificarVenta($pedido, $venta);
            echo 'Se modifico la venta';
        }else{
            echo 'La venta no pudo ser modificada porque no existe';
        }
    }
}
?>