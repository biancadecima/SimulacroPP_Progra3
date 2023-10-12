<?php
//index.php:Recibe todas las peticiones que realiza el postman, y administra a que archivo se debe incluir.
//include "./pizza.php";

/*if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET["sabor"]) && isset($_GET["precio"]) && isset($_GET["tipo"]) && isset($_GET["cantidad"])){
        $sabor = $_GET["sabor"];
        $precio = $_GET["precio"];
        $tipo = $_GET["tipo"];
        $cantidad = $_GET["cantidad"];
        $pizza = new Pizza($sabor, $precio, $tipo, $cantidad);
    }
}else if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_GET["sabor"]) && isset($_GET["tipo"])){
        $pizza = new Pizza($sabor, $tipo);
    }
}    */

switch($_SERVER['REQUEST_METHOD']){
    case "POST":
        if(isset($_POST['accion'])){
            if($_POST['accion'] === 'consultar'){
                include "./PizzaConsultar.php";
                echo pizzaConsultar();
            }
        }else{
            echo "Error. Faltan parametros.";
        }
        break;
    case "GET":
        if(isset($_GET['accion'])){
            if($_GET['accion'] === 'cargar'){
                include "./PizzaCarga.php";
                echo pizzaCarga(); 
            }
        }else{
            echo "Error. Faltan parametros.";
        }
        break;
}
?>