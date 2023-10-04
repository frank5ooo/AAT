<?php

namespace TrabajoSube;

require 'tarjeta.php';

class MedioBoleto extends Tarjeta {
    public function descontar($precio) {
        // Aplicar descuento del 50%
        $precioDescuento = $precio / 2;
        
        if ($this->saldo >= $precioDescuento) {
            $this->saldo -= $precioDescuento;
            return true;
        } else {
            if($this->saldo >= -91.84)  //-91.84 ya que en caso de tener un saldo igual o mayor a este al descontarle los 120 quedaria un saldo igual o mayor a -211.84 
            {
                $this->saldo -= $precio;
                echo "Viaje Plus utilizado";
                return true;
            }
            else
            {
                echo "Viaje Plus no disponible. \n";
                return false;
            }
        }
    }
}