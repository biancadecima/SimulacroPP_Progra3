<?php
include "./pizza.php";
function pizzaConsultar(){
    if(!isset($_POST["sabor"]) || !isset($_POST["tipo"])){
        echo "Error. Faltan parametros para la consulta de pizza.";
    }else{
        $sabor = $_POST["sabor"];
        $tipo = $_POST["tipo"];
        $pizzas = Pizza::LeerJSONPizzas();
        foreach($pizzas as $pizza){
            if($pizza['tipo'] === $tipo && $pizza['sabor'] === $sabor){
                return 'Si hay';
            }
        }
        if(!Pizza::SaborExiste($sabor) && Pizza::TipoExiste($tipo)){
            return 'No existe el sabor';
        }else if(!Pizza::TipoExiste($tipo) && Pizza::SaborExiste($sabor)){
            return 'No existe el tipo';
        }

        return 'No existe ni sabor, ni tipo';
    }
}
?>