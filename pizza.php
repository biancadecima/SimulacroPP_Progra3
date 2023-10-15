<?php
Class Pizza{
    public $id;
    public $sabor;
    public $precio;
    public $tipo;
    public $cantidad;

  
    public function __construct($sabor, $precio, $tipo, $cantidad)
    {
        $this->id = rand(1, 100);
        $this->sabor = $sabor;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
    }

    public static function LeerJSONPizzas(){
        $pathJSON = './pizza.json';
        if(file_exists($pathJSON)){
            $pizzas = json_decode(file_get_contents($pathJSON), true);
            if($pizzas != null){
                return $pizzas;
            }  
        }
        return [];
    }

    public static function EscribirJSONPizzas($pizzas){
        if(file_put_contents('pizza.json', json_encode($pizzas)) != false){
            return true;
        }
        
        return false;
    }

    public function PizzaExiste(){
        $arrayPizzas = Pizza::LeerJSONPizzas();
        if(count($arrayPizzas)> 0){
            foreach($arrayPizzas as &$pizza){
                if($pizza['tipo'] === $this->tipo && $pizza['sabor'] === $this->sabor){
                    $pizza['precio'] = $this->precio;
                    $pizza['cantidad'] += $this->cantidad;
                    Pizza::EscribirJSONPizzas($arrayPizzas);
                    return true;
                }
            }
        }
       
        return false;
    }

    public static function TipoExiste($tipo){
        $arrayPizzas = Pizza::LeerJSONPizzas();
        foreach($arrayPizzas as $pizza){
            if($pizza['tipo'] === $tipo){
                return true;
            }
        }
        return false;
    }

    public static function SaborExiste($sabor){
        $arrayPizzas = Pizza::LeerJSONPizzas();
        foreach($arrayPizzas as $pizza){
            if($pizza['sabor'] === $sabor){
                return true;
            }
        }
        return false;
    }

    public static function ConsultarStock($sabor, $tipo){
        $arrayPizzas = Pizza::LeerJSONPizzas();
        foreach($arrayPizzas as $pizza){
            if($pizza['tipo'] === $tipo && $pizza['sabor'] === $sabor){
                return $pizza['cantidad'];
            }
        }
        return false;
    }

    public static function ActualizarStock($tipo,$sabor, $cantidadventa){
        $arrayPizzas = Pizza::LeerJSONPizzas();
        foreach($arrayPizzas as &$pizza){
            if($pizza['tipo'] === $tipo && $pizza['sabor'] === $sabor){
                $pizza['cantidad'] =  ($pizza['cantidad'] - $cantidadventa);
                Pizza::EscribirJSONPizzas($arrayPizzas);
                return true;
            }
        }
        return false;
    }
}
?>