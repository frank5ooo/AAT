<?php

namespace TrabajoSube;

use TrabajoSube\tarjeta;

class MedioBoleto extends Tarjeta {
    public $viajesHoy= 0;
    private $fechaActual;

    private $saldoMedioBoleto = 0;
    
    public function __construct($fechaActual) {
        $this->fechaActual = $fechaActual;
    }

    public function descontarMedioBoleto() 
    {   
        $this->saldoMedioBoleto = $this->getSaldo();
        $precioDescuento = $this->getPrecio()/2;

        if ($this->viajesHoy >= 4) {
          
            if ($this->saldoMedioBoleto >= $this->getPrecio()) 
            {
                $this->saldoMedioBoleto -= $this->getPrecio();
                echo "Ha alcanzado el límite de 4 viajes con medio boleto hoy. Se le cobrará el precio completo.\n";
                return true;
            }  
            if ($this->saldoMedioBoleto >= -151.84) 
            {
                $this->saldoMedioBoleto -= $this->getPrecio();
                echo "Ha alcanzado el límite de 4 viajes con medio boleto hoy, se utilizará un viaje plus.\n";
                return true;
            } 
            else 
            {
                echo "Ha alcanzado el límite de 4 viajes con medio boleto hoy y no tiene saldo suficiente.\n";
                return false;
            }
        }
        else
        {
            if ($this->fechaActual->time() < 300) // Menos de 5 minutos
            { 
                echo "Debe esperar al menos 5 minutos antes de realizar otro viaje.". $this->fechaActual->time();
                echo "tiempo" . $this->fechaActual->time();
                return false;
            }
            // Aplicar descuento del 50%

            if ($this->saldoMedioBoleto >= $precioDescuento) 
            {
                $this->saldoMedioBoleto -= $precioDescuento;
                $this->viajesHoy++;     
                return true;
            } 
            else 
            {
                if ($this->saldoMedioBoleto >= -151.84) 
                {
                    $this->saldoMedioBoleto -= $this->getPrecio();
                    echo "Viaje Plus utilizado.\n";
                    return true;
                } 
                else 
                {
                    echo "nasheViaje Plus no disponible. \n";
                    echo "El saldo ES" . $this->saldoMedioBoleto."\n" ;
                    return false;
                }
            }
        }
    }

    public function getSaldoMedioBoleto()
    {
        return $this->saldoMedioBoleto;
    }
}

?>