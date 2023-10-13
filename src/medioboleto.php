<?php

namespace TrabajoSube;

use TrabajoSube\tarjeta;

class MedioBoleto extends Tarjeta {
    private $ultimaMarcaTiempo = null;
    private $viajesHoy= 0;
    private $fechaActual;
   
    public function __construct() {
        $this->fechaActual = date("Y-m-d");
    }

    private $saldoMedioBoleto = 0;

    public function descontarMedioBoleto($precio) 
    {   
        $this->saldoMedioBoleto = $this->getSaldo();

        $fechaNueva = date("Y-m-d");
        
        if ($fechaNueva != $this->fechaActual) {
            $this->viajesHoy = 0;
            $this->fechaActual = $fechaNueva;
        }

        if ($this->viajesHoy >= 4) {
          
            if ($this->saldoMedioBoleto >= $precio) {
                $this->saldoMedioBoleto -= $precio;
                echo "Ha alcanzado el límite de 4 viajes con medio boleto hoy. Se le cobrará el precio completo.\n";
                return true;
            }  if ($this->saldoMedioBoleto >= -151.84) {
                $this->saldoMedioBoleto -= $precio;
                echo "Ha alcanzado el límite de 4 viajes con medio boleto hoy, se utilizará un viaje plus.\n";
                return true;
            } else {
                echo "Ha alcanzado el límite de 4 viajes con medio boleto hoy y no tiene saldo suficiente.\n";
                return false;
            }
        }
        else{
            // Verificar el tiempo entre viajes
            $marcaActual = time();

            if ($this->ultimaMarcaTiempo !== null && ($marcaActual - $this->ultimaMarcaTiempo) < 300) 
            { // Menos de 5 minutos
                echo "Debe esperar al menos 5 minutos antes de realizar otro viaje.\n";
                return false;
            }
            // Aplicar descuento del 50%
            $precioDescuento = $precio / 2;

            if ($this->saldoMedioBoleto >= $precioDescuento) 
            {
                echo "entra NASHE EN EL IF.\n";

                $this->saldoMedioBoleto -= $precioDescuento;
                $this->ultimaMarcaTiempo = $marcaActual;
                $this->viajesHoy++;
                return true;
            } 
            else 
            {
                if ($this->saldoMedioBoleto >= -151.84) 
                {
                    $this->saldoMedioBoleto -= $precio;
                    echo "\n El saldo ES" . $this->saldoMedioBoleto."\n" ;
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

    public function setUltimoTiempo()
    {
        $this->ultimaMarcaTiempo = null;
    }

    public function setSaldoMedioBoleto()
    {
        return $this->saldoMedioBoleto;
    }
}
?>