<?php
include "./venta.php";
function ventaConsultar(){
    if(!isset($_GET["fechaUno"]) || !isset($_GET["fechaDos"]) || !isset($_GET["mail"]) || !isset($_GET["sabor"])){
        echo 'Error. Faltan parametros para la consulta de venta.';
    }else{
        $fechaUno = $_GET["fechaUno"];
        $fechaDos = $_GET["fechaDos"];
        $usuario = $_GET["mail"];
        $sabor = $_GET["sabor"];

        $ventas = Venta::LeerJSONVentas();
        if($cantidad = Venta::CantidadVentas($ventas)){
            echo 'La cantidad de pizzas vendidas es de '.$cantidad. "\n\n";
        }
        if($ventasFiltradas = Venta::FiltrarPorFechas($ventas, $fechaUno, $fechaDos))
            $ventasOrdenado = Venta::OrdenarPorSabor($ventasFiltradas);
            echo "b- Ventas realizadas entre el: ", $fechaUno, " y el: ", $fechaDos, "\n\n";
            Venta::MostrarVentas($ventasOrdenado);
        
        if($ventasUsuario = Venta::FiltarPorUsuario($ventas, $usuario)){
            echo 'Ventas realizadas por el usuario'.$usuario. "\n\n";
            Venta::MostrarVentas($ventasUsuario);
        }
        if($ventasSabor = Venta::FiltrarPorSabor($ventas, $sabor)){
            echo 'Ventas realizadas por del sabor'.$sabor. "\n\n";
            Venta::MostrarVentas($ventasSabor);
        }

    }
}

?>