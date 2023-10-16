<?php

namespace TrabajoSube;

use TrabajoSube\tarjeta;

class MedioBoleto extends Tarjeta {
    protected $viajesHoy = 0;
    protected $cantViajesMedioBoleto=4;
    private $medioBoleto;

    public function descontarMedioBoleto($boleto) 
    {   
        //$medioBoleto = $boleto/2;
        $tiempoActual = $this->tiempo->time();
        $medioBoleto = $this->precio/2;

        if(intval($this->viajesHoy/86400) < intval($this->tiempo->time()/86400))
        {
            $this->cantViajesMedioBoleto=4;
        }

        if($this->cantViajesMedioBoleto > 0)
        {   
            if ($tiempoActual < 300) // Menos de 5 minutos
            { 
                echo "Debe esperar al menos 5 minutos antes de realizar otro viaje.". $tiempoActual;
                
                return false;
            }
            // // Aplicar descuento del 50%
            if ($this->saldo >= $medioBoleto) 
            {   
                $this->cantViajesMedioBoleto--;
                $this->saldo -= $medioBoleto;
                $this->viajesHoy = $tiempoActual;
                return true;
            } 
            else 
            {
                if ($this->saldo >= -151.84) 
                {   
                    echo "this->saldo\n". $this->saldo;
                    $this->saldo-= $this->precio;
                    echo "Viaje Plus utilizado.\n";
                    return true;
                } 
                else 
                {
                    echo "nasheViaje Plus no disponible. \n";
                    echo "El saldo ES" . $this->saldo."\n" ;
                    return false;
                }
            }
        }
        else{
            return $this->descontar($boleto);
        }
    }
    public function GetCantViajesMedioBoleto()
    {
        return $this->cantViajesMedioBoleto;
    }
}

?>