<?php
class Venta{
    public $id;
    public $email;
    public $fecha;
    public $pedido;
    public $sabor;
    public $tipo;
    public $cantidad;
    
    public function __construct(){
        //obtengo un array con los parámetros enviados a la función
		$params = func_get_args();
		//saco el número de parámetros que estoy recibiendo
		$num_params = func_num_args();
		//cada constructor de un número dado de parámtros tendrá un nombre de función
		//atendiendo al siguiente modelo __construct1() __construct2()...
		$funcion_constructor ='__construct'.$num_params;
		//compruebo si hay un constructor con ese número de parámetros
		if (method_exists($this,$funcion_constructor)) {
			//si existía esa función, la invoco, reenviando los parámetros que recibí en el constructor original
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
    }

    public function __construct4($email, $sabor, $tipo, $cantidad) {
        $this->id = rand(1, 100);
        $this->email = $email;
        $this->fecha = date("d-m-Y");
        $this->pedido = rand(1, 100);
        $this->sabor = $sabor;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;

    }

    public function __construct7($id, $email, $fecha, $pedido, $sabor, $tipo, $cantidad) {
        $this->id = $id;
        $this->email = $email;
        $this->fecha = $fecha;
        $this->pedido = $pedido;
        $this->sabor = $sabor;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
    }

    public static function LeerJSONVentas(){
        $pathJSON = './venta.json';
        if(file_exists($pathJSON)){
            $ventas = json_decode(file_get_contents($pathJSON), true);
            if($ventas != null){
                return $ventas;
            }  
        }
        return [];
    }

    public static function EscribirJSONVentas($ventas){
        if(file_put_contents('venta.json', json_encode($ventas)) != false){
            return true;
        }
        
        return false;
    }

    //completar el alta con imagen de la venta , guardando la imagen con el tipo+sabor+mail(solo usuario hasta
    //el @) y fecha de la venta en la carpeta /ImagenesDeLaVenta.
    public function DestinoImagenVenta($ruta){
        $usuario = strtok($this->email, '@');
        $destino = $ruta."\\".$this->tipo."-".$this->sabor."-".$usuario."-".$this->fecha.".png";
        return $destino;
    }

    public static function CantidadVentas($ventas){
        $total = 0;
        if(count($ventas) > 0){
           foreach($ventas as $venta){
                $total += $venta['cantidad'];
            } 
            return $total;
        }
        
        return false;
    }

    public static function FiltrarPorFechas($ventas, $fechaInicio, $fechaFin){
        $inicio = strtotime($fechaInicio);
        $fin = strtotime($fechaFin);
        $ventasFiltradas = array();
        foreach($ventas as $venta){
            if(strtotime($venta['fecha'])>= $inicio && strtotime($venta['fecha']) <= $fin){
                array_push($ventasFiltradas, $venta);
            }
        }
        if(count($ventasFiltradas) > 0){
            return $ventasFiltradas;
        }else{
            return false;
        }
    }

    public static function CompararSabor($a, $b){
        return strcmp($a['sabor'], $b['sabor']);
    } 

    public static function OrdenarPorSabor($ventas){
        usort($ventas, 'Venta::CompararSabor');
        return $ventas;
    }

    public static function MostrarVentas($ventas){
        if(count($ventas) > 0){
            foreach($ventas as $venta){
                echo "Id: ".$venta['id'] ."\n";
                echo "Mail: ".$venta['email'] ."\n";
                echo "Sabor: ".$venta['sabor'] ."\n";
                echo "Tipo: ".$venta['tipo'] ."\n";
                echo "Cantidad: ".$venta['cantidad'] ."\n";
                echo "Fecha: ".$venta['fecha'] ."\n";
                echo "Pedido: ".$venta['pedido'] ."\n";
                echo "\n";
            }
        }
    }

    public static function FiltarPorUsuario($ventas, $mail){
        $filtrado = array();
        if(count($ventas) > 0){
            foreach($ventas as $venta){
                if($venta['email'] == $mail){
                    array_push($filtrado, $venta);
                }
            }
            return $filtrado;
        }
        return false;
    }

    public static function FiltrarPorSabor($ventas, $sabor){
        $filtrado = array();
        if(count($ventas) > 0){
            foreach($ventas as $venta){
                if($venta['sabor'] == $sabor){
                    array_push($filtrado, $venta);
                }
            }
            return $filtrado;
        }
        return false;
    }

    public static function VentaExiste($pedido){
        $ventas = Venta::LeerJSONVentas();
        if(count($ventas) > 0){
            foreach($ventas as $venta){
                if($venta['pedido'] == $pedido){
                    return true;
                }
            }
        }
        return false;
    }

    public static function ModificarVenta($pedido, $ventaModificada){
        $ventas = Venta::LeerJSONVentas();
        if(count($ventas) > 0){
            foreach($ventas as &$venta){
                if($venta['pedido'] == $pedido){
                    $venta['email'] = $ventaModificada->email;
                    $venta['sabor'] = $ventaModificada->sabor;
                    $venta['tipo'] = $ventaModificada->tipo;
                    $venta['cantidad'] = $ventaModificada->cantidad;
                    Venta::EscribirJSONVentas($ventas);
                    return true;
    
                }
            }
        }
        return false;
    }

    public static function BorrarVenta($pedido, $rutaOrigen, $rutaEliminada){
        $ventas = Venta::LeerJSONVentas();
        if(count($ventas) > 0){
            foreach($ventas as $venta){
                if($venta['pedido'] == $pedido){
                    $ventaABorrar = new Venta($venta['id'], $venta['email'], $venta['fecha'], $venta['pedido'], $venta['sabor'], $venta['tipo'], $venta['cantidad']);
                    $index = array_search($venta, $ventas);
                }
            }
            var_dump($index);
            if($index !== false){
                 $imagenOrigen = $ventaABorrar->DestinoImagenVenta($rutaOrigen);
                $imagenBorrada = $ventaABorrar->DestinoImagenVenta($rutaEliminada);
                unset($ventas[$index]);
                Venta::EscribirJSONVentas($ventas);
                echo 'Venta borrada. ';
            }
  
            if(rename($imagenOrigen, $imagenBorrada)){
                echo 'Se movió la imagen a backup';
            }else{
                echo 'No se pudo mover la imagen';
            }
        }    
    }
}
?>