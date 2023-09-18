<?php

namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\tarjeta;
use TrabajoSube\colectivo;
use TrabajoSube\boleto;
use Exception;

class ColectivoTest extends TestCase {
    private $montosValidos = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 
                800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 
                2500, 3000, 3500, 4000];

    public function testRecargarConMontoValido() {
        // Crear una instancia de la clase Tarjeta con un saldo inicial de 0
        $tarjeta = new Tarjeta(00);
        
        foreach ($this->montosValidos as $monto) {
            //$tarjetaCopia = $tarjeta;
    
            $saldoInicial = $tarjeta->saldo;
    
            $tarjeta->recargar($monto);
    
            $saldoEsperado = min($saldoInicial + $monto, 6600);
    
            $this->assertEquals($saldoEsperado, $tarjeta->saldo);
        }
    }
}
