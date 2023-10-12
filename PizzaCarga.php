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
        var_dump($pizza);
        if($pizza->PizzaExiste() == false){
            $pizzas = Pizza::LeerJSONPizzas();
            $pizzas[] = $pizza;
            Pizza::EscribirJSONPizzas($pizzas);
            return 'Se cargó la pizza';
        }
        return 'La pizza ya existe, y fue actualizada';
    }
}

?>6