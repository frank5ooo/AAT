<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase{

    public function testCalcularTarifa() {
        // Crear una instancia de Colectivo y Tarjeta, y realizar un pago para cada monto de pago aceptado.
        $colectivo = new Colectivo();
        $tarjeta = new Tarjeta();
        
        $montosDePago = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000];
        
        foreach ($montosDePago as $monto) {
            // Realizar el pago en el colectivo.
            $boleto = $colectivo->pagarCon($tarjeta);
            
            // Verificar que la tarifa del boleto sea igual al monto de pago actual.
            $this->assertEquals($monto, $boleto->getTarifa());
        }
    }
   
}