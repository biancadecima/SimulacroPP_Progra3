<?php
class Venta{
    public $id;
    public $email;
    public $fecha;
    public $pedido;
    public $sabor;
    public $tipo;
    public $cantidad;
    
    public function __construct($email, $sabor, $tipo, $cantidad) {
        $this->id = rand(1, 100);
        $this->email = $email;
        $this->fecha = date("d-m-Y");
        $this->pedido = rand(1, 100);
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
}
?>