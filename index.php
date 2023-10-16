<?php
$rutaImagenVenta = 'C:\xampp\htdocs\SimulacroPP\ImagenesVenta';
$rutaImagenPizza = 'C:\xampp\htdocs\SimulacroPP\ImagenesPizza';
$rutaBackUp = 'C:\xampp\htdocs\SimulacroPP\BACKUPVENTAS';

switch($_SERVER['REQUEST_METHOD']){
    case "POST":
        if(isset($_POST['accion'])){
            switch($_POST['accion']){
                case 'consultar':
                    include "./PizzaConsultar.php";
                    echo pizzaConsultar();
                    break;
                case 'venta':
                    include "./AltaVenta.php";
                    echo altaVenta($rutaImagenVenta);
                    break;
                case 'cargar':
                    include "./PizzaCarga.php";
                    echo pizzaCargaConImagen($rutaImagenPizza);
                    break;
                case 'modificar':
                    include './ModificarVenta.php';
                    modificarVenta();
                    break;
                case 'borrar':
                    include './BorrarVenta.php';
                    borrarVenta($rutaImagenVenta, $rutaBackUp);
                    break;
            }
        }else{
            echo "Error. Faltan parametros.";
        }
        break;
    case "GET":
        if(isset($_GET['accion'])){
            switch($_GET['accion']){
                case 'cargar':
                    include "./PizzaCarga.php";
                    echo pizzaCarga();
                    break;
                case 'consultarventas':
                    include './VentasConsultar.php';
                    ventaConsultar();
                    break; 
            }
        }else{
            echo "Error. Faltan parametros.";
        }
        break;

}
?>