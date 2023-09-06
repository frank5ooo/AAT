<?php

namespace TrabajoSube;
class Tarjeta {
    public $saldo;
    private $limite_saldo = 6600;
    const  cargasAceptadas = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000];

    public function __construct($saldo) {
        $this->saldo = $saldo;
    }

    public function recargar($monto) {
        if (in_array($monto, cargasAceptadas)) {
            $this->saldo += $monto;
            if ($this->saldo > $this->limite_saldo) {
                $this->saldo = $this->limite_saldo;
            }
        }
    }

    public function descontar($precio) {
        if ($this->saldo >= $precio) {
            $this->saldo -= $precio;
            return true;
        }
        else{
            if( ($this->saldo - $precio) >= -211.84){
                $this->saldo -= $precio;
                echo "Viaje Plus utilizado";
                return true;
            }
            else{
                return false;
            }
        }
        
    }
    public function getSaldo() {
      return $this->saldo;
    }
}


// Crear una tarjeta con saldo inicial
$tarjeta = new Tarjeta(500);

?>