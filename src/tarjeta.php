<?php

namespace TrabajoSube;

class Tarjeta {
    public $saldo;
    private $limite_saldo = 6600;
    public $precio = 120;

    const cargasAceptadas = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 
                            800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 
                            2500, 3000, 3500, 4000];

    public function __construct($saldo) 
    {
        $this->saldo = $saldo;
    }

    public function recargar($monto) 
    {
        if (in_array($monto, self::cargasAceptadas)) 
        {
            $this->saldo += $monto;
            if ($this->saldo > $this->limite_saldo) 
            {
                $this->saldo = $this->limite_saldo;
            }
        }
        else
        {
            echo ("Monto de recarga no válido: $monto");
        }
    }

    public function descontar($precio) 
    {
        if ($this->saldo >= $precio)
        {
            $this->saldo -= $precio;
            return true;
        }
        else
        {
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
    public function getSaldo() {
      return $this->saldo;
    }
}


$tarjeta = new Tarjeta(200);
