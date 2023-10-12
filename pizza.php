<?php
Class Pizza{
    private $_id;
    private $_sabor;
    private $_precio;
    private $_tipo;
    private $_cantidad;

    /*public function __construct2($sabor, $tipo){
        $this->__construct4(rand(1, 100), $sabor, 0, $tipo, 0);
    }*/

    public function __construct($sabor, $precio, $tipo, $cantidad)
    {
        $this->_id = rand(1, 100);
        $this->_sabor = $sabor;
        $this->_precio = $precio;
        $this->_tipo = $tipo;
        $this->_cantidad = $cantidad;
    }

    public static function LeerJSONPizzas(){
        $pathJSON = './pizza.json';
        if(file_exists($pathJSON)){
            $pizzas = json_decode(file_get_contents($pathJSON), true);
            if($pizzas != null){
                return $pizzas;
            }  
        }
        return false;
    }

    public static function EscribirJSONPizzas($pizzas){
        
        
       /* $pizza = ['id'=> $this->_id,
        'sabor'=> $this->_sabor,
        'precio'=> $this->_precio,
        'tipo'=> $this->_tipo,
        'cantidad'=> $this->_cantidad];

        $arrayPizzas = [];
        if(file_exists('pizza.json')){
            $arrayPizzas = json_decode(file_get_contents('pizza.json'), true);
        }
        $arrayPizzas[] = $pizza;*/
        
        if(file_put_contents('pizza.json', json_encode($pizzas)) != false){
            return true;
        }
        
        return false;
    }

    public function PizzaExiste(){
        $arrayPizzas = Pizza::LeerJSONPizzas();
        foreach($arrayPizzas as $pizza){
            if($pizza->tipo === $this->_tipo && $pizza->sabor === $this->_sabor){
                $pizza->_precio = $this->_precio;
                $pizza->_cantidad += $this->_cantidad;
                Pizza::EscribirJSONPizzas($arrayPizzas);
                return true;
            }
        }
        return false;
    }

    public static function TipoExiste($tipo){
        $arrayPizzas = Pizza::LeerJSONPizzas();
        foreach($arrayPizzas as $pizza){
            if($pizza->tipo === $tipo){
                return true;
            }
        }
        return false;
    }

    public static function SaborExiste($sabor){
        $arrayPizzas = Pizza::LeerJSONPizzas();
        foreach($arrayPizzas as $pizza){
            if($pizza->_sabor === $sabor){
                return true;
            }
        }
        return false;
    }
}
?>