<?php
include "./venta.php";
include "./pizza.php";
function altaVenta($ruta){
    if(!isset($_POST["email"]) || !isset($_POST["sabor"]) || !isset($_POST["tipo"]) || !isset($_POST["cantidad"]) || !isset($_FILES["imagen"])){
       $respuesta = 'Error. Faltan parametros para el alta de venta.';
    }else{
        $email = $_POST['email'];
        $sabor = $_POST['sabor'];
        $tipo = $_POST['tipo'];
        $cantidad =  $_POST['cantidad'];
        $imagen = $_FILES['imagen'];

        $venta = new Venta($email, $sabor, $tipo, $cantidad);
        if(!Pizza::TipoExiste($tipo) && !Pizza::SaborExiste($sabor)){
            return 'No se puede realizar la venta porque no existe la pizza';
        }else if(Pizza::ConsultarStock($sabor, $tipo) >= $cantidad){
            Pizza::ActualizarStock($tipo, $sabor, $cantidad);
            $ventas = Venta::LeerJSONVentas();
            $ventas[] = $venta;
            Venta::EscribirJSONVentas($ventas);
            $respuesta = 'Alta de venta exitosa';
            if(move_uploaded_file($imagen['tmp_name'], $venta->DestinoImagenVenta($ruta))){
                $respuesta = $respuesta.' '.'Se guardó la imagen';
            }else{
                $respuesta = $respuesta.' '.'La imagen no pudo ser guardada';
            }
        }else{
            $respuesta = 'No se puede realizar la venta porque no hay stock suficiente';
        }
    }
    return $respuesta;
}

?>