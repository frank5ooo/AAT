<?php

namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\tarjeta;
use TrabajoSube\colectivo;
use TrabajoSube\boleto;
use Exception;

class ColectivoTest extends TestCase {
    public function montosValidos() {
        // Retorna un array de montos válidos
        return [[150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 
                800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 
                2500, 3000, 3500, 4000]];
    }

    /**
     * @dataProvider montosValidos
     */
    public function testRecargarConMontoValido($monto) {
        // Crear una instancia de la clase Tarjeta con un saldo inicial
        $tarjeta = new Tarjeta(6500); // Aquí asumimos que $tarjeta tiene un valor
    
        // Obtener el saldo inicial antes de la recarga
        $saldoInicial = $tarjeta->saldo;
    
        // Intentar recargar con un monto válido
        $tarjeta->recargar($monto);
    
        // Verificar que el saldo se haya actualizado correctamente después de la recarga
        
        if($saldoInicial + $monto <=6600)
        {
            $this->assertEquals($saldoInicial + $monto, $tarjeta->saldo);
        }
        else 
        {
            $this->assertEquals(6600, $tarjeta->saldo);
        }

    }
}