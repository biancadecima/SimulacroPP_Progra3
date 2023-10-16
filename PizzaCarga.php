<?php
include "./pizza.php";
//guardar datos en archivo json
//(primero deberia hacer esto) buscar en el archivo si el sabor y tipo existen
// en el caso de que existan, se actualiza el precio y se suma al stock existente
function pizzaCarga(){
    if(!isset($_GET["sabor"]) || !isset($_GET["precio"]) || !isset($_GET["tipo"]) || !isset($_GET["cantidad"])){
        return "Error. Faltan parametros para la carga de pizza.";
    }else{
        $sabor = $_GET["sabor"];
        $precio = $_GET["precio"];
        $tipo = $_GET["tipo"];
        $cantidad = $_GET["cantidad"];
        $pizza = new Pizza($sabor, $precio, $tipo, $cantidad);
        if($pizza->PizzaExiste() == false){
            $pizzas = Pizza::LeerJSONPizzas();
            $pizzas[] = $pizza;
            Pizza::EscribirJSONPizzas($pizzas);
            return 'Se cargó la pizza';
        }
        return 'La pizza ya existe, y fue actualizada';
    }
}

function pizzaCargaConImagen($ruta){
    if(!isset($_POST["sabor"]) || !isset($_POST["precio"]) || !isset($_POST["tipo"]) || !isset($_POST["cantidad"]) || !isset($_FILES["imagen"])){
      return "Error. Faltan parametros para la carga de pizza.";
    }else{
        $sabor = $_POST["sabor"];
        $precio = $_POST["precio"];
        $tipo = $_POST["tipo"];
        $cantidad = $_POST["cantidad"];
        $imagen = $_FILES["imagen"];

        $pizza = new Pizza($sabor, $precio, $tipo, $cantidad);
        if($pizza->PizzaExiste() == false){
            $pizzas = Pizza::LeerJSONPizzas();
            $pizzas[] = $pizza;
            Pizza::EscribirJSONPizzas($pizzas);
            $respuesta = 'Se cargó la pizza';
            if(move_uploaded_file($imagen['tmp_name'], $pizza->DestinoImagenPizza($ruta))){
                $respuesta = $respuesta.' '.'Se guardó la imagen';
            }else{
                $respuesta = $respuesta.' '.'La imagen no pudo ser guardada';
            }
        }else{
           $respuesta = 'La pizza ya existe, y fue actualizada'; 
        }
        
    }
    return $respuesta;
}

?>