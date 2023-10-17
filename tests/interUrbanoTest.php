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


    public function testDescontarSinSaldoInterUrbano()
    {   
        $interUrbano = new LineaInterUrbano(144);
        $tiempo = new TiempoFalso;

        $tarjeta = new Tarjeta(1,$tiempo);

        $boletoInterUrbano = $interUrbano->getPrecio();

        $tarjeta->recargar(150);
        
        $resultado = $tarjeta->descontar($boletoInterUrbano);   //viaje 2

        $this->assertTrue($resultado);
        $this->assertEquals(-34, $tarjeta->getSaldo());

        $resultado = $tarjeta->descontar($boletoInterUrbano); 
        $this->assertFalse($resultado);
    }
}
?>