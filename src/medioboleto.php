<?php
namespace TrabajoSube;
use TrabajoSube\tarjeta;
class MedioBoleto extends Tarjeta {
    protected $viajesHoy = 0;
    protected $cantViajesMedioBoleto=4;
    private $medioBoleto;
    private $tiempoActual=0;
    public function descontarMedioBoleto($boleto) 
    {   
        $medioBoleto = $boleto/2;
        $this->tiempoActual = $this->tiempo->time();
        $diaSemana= date('l', $this->tiempo->time());

        //echo"\ndiaSemana ".$diaSemana;

        $horaDia= date('G', $this->tiempo->time());
        //echo"\nhoraDia ". $horaDia;


        if(intval($this->viajesHoy/86400) < intval($this->tiempo->time()/86400))
        {
            $this->cantViajesMedioBoleto=4;
        }

        if($diaSemana !== "Sunday" && $diaSemana !== "Saturday" && $horaDia >=6 && $horaDia <=22)
        {
            if(($this->tiempoActual % 300) >= 1 && $this->tiempoActual > 0 ) // Menos de 5 minutos
            {
                echo "Debe esperar al menos 5 minutos antes de realizar otro viaje.";
                return false;
            }
            if($this->cantViajesMedioBoleto > 0)
            {   
                // // Aplicar descuento del 50%
                if ($this->saldo >= $medioBoleto) 
                {   
                    $this->cantViajesMedioBoleto--;
                    $this->saldo -= $medioBoleto;
                    $this->viajesHoy = $this->tiempoActual;
                    return true;
                } 
                else 
                {
                    return $this->descontar($boleto);
                }
            }
            else
            {
                return $this->descontar($boleto);
            }
        }
        else
        {
            return $this->descontar($boleto);
        }
    }

    public function GetCantViajesMedioBoleto()
    {
        return $this->cantViajesMedioBoleto;
    }
}
?>