<?php

namespace TrabajoSube;

use TrabajoSube\tarjeta;

class FranquiciaCompleta extends Tarjeta 
{
    protected $viajesHoy = 0;
    protected $cantViajesGratis=2;

    public function descontarFranquiciaCompleta($boleto) 
    {   
        $tiempoActual = $this->tiempo->time();

        if(intval($this->viajesHoy/86400) < intval($this->tiempo->time()/86400))
        {
            $this->cantViajesGratis=2;
        }       

        if($this->cantViajesGratis > 0)
        {
            $this->cantViajesGratis--;
            $this->viajesHoy = $tiempoActual;
            return true;
        }
        
        else
        {
            return $this->descontar($boleto);
        }
    }

    public function getCantViajesGratis()
    {
        return $this->cantViajesGratis;
    }

}