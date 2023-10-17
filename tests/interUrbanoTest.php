<?php

namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\tarjeta;
use TrabajoSube\tiempoFalso;
use TrabajoSube\lineaInterUrbano;

class interUrbanoTest extends TestCase 
{
    public function testDescontarInterUrbano()
    {   
        $interUrbano = new LineaInterUrbano(144);
        $boletoInterUrbano = $interUrbano->getPrecio();

        $tiempo = new TiempoFalso;

        $tarjeta = new Tarjeta(1,$tiempo);

        $tarjeta->recargar(2000);
        
        $resultado = $tarjeta->descontar($boletoInterUrbano);

        $this->assertTrue($resultado);
        $this->assertEquals(2000 - $boletoInterUrbano, $tarjeta->getSaldo());
    }
}
?>