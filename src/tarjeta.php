<?php
namespace TrabajoSube;
    class Tarjeta
    {
        public $saldo;
        private $limite_saldo = 6600;

        public function __construct(){
            $this->saldo = 0;
        }
        
        public function recargar($monto) {
            $cargasAceptadas = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000];
            if (in_array($monto, $cargasAceptadas)) {
                $this->saldo += $monto;
                if ($this->saldo > $this->limite_saldo) {
                    $this->saldo = $this->limite_saldo;
                }
            }
        }
        public function pagar($costo) {
            $this->saldo -= $costo;
        }
        public function getSaldo() {
            return $this->saldo;
          }
    }

    $tarjeta = new Tarjeta();


?>