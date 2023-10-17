<?php

namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\tarjeta;
use TrabajoSube\tiempoFalso;
use TrabajoSube\lineaInterUrbano;

class TarjetaTest extends TestCase 
{
    private $montosValidos = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 
                800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 
                2500, 3000, 3500, 4000];

    private $boletoUrbano = 120;
    private $boletoInterUrbano = 184;

    public function testRecargar() 
    {
        $tiempo = new TiempoFalso;
        
        foreach ($this->montosValidos as $monto) 
        {        
            $tarjeta = new Tarjeta(1,$tiempo);

            $saldoInicial = $tarjeta->getSaldo();
    
            $tarjeta->recargar($monto);
    
            $saldoEsperado = min($saldoInicial + $monto, 6600);
    
            $this->assertEquals($saldoEsperado, $tarjeta->getSaldo());
        }
    }

    public function testRecargarMontoNoAceptado()
    {
        $tiempo = new TiempoFalso;
        $tarjeta = new Tarjeta(1, $tiempo);
    
        $tarjeta->recargar(100);
    
        $this->assertEquals(0, $tarjeta->getSaldo()); 
    }

    public function testDescontarUrbano()
    {
        $tiempo = new TiempoFalso;

        $tarjeta = new Tarjeta(1,$tiempo);

        $tarjeta->recargar(2000);
        
        $resultado = $tarjeta->descontar($this->boletoUrbano);

        $this->assertTrue($resultado);
        $this->assertEquals(2000 - $this->boletoUrbano, $tarjeta->getSaldo());
    }

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

  
    public function testDescontarSinSaldoUrbano()
    {
        $tiempo = new TiempoFalso;

        $tarjeta = new Tarjeta(1,$tiempo);

        $tarjeta->recargar(150);
        
        $tarjeta->descontar($this->boletoUrbano);   //viaje 1

        $resultado = $tarjeta->descontar($this->boletoUrbano);   //viaje 2

        $this->assertTrue($resultado);
        $this->assertEquals(-90, $tarjeta->getSaldo());

        $resultado = $tarjeta->descontar($this->boletoUrbano);   //viaje 3

        $this->assertFalse($resultado);
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

    public function testRecargaConExcedente()
    {
        $tiempo = new TiempoFalso;
        $tarjeta = new Tarjeta(1,$tiempo);
        $tarjeta->recargar(4000);  
        $tarjeta->recargar(4000);  
    
        $this->assertEquals(6600, $tarjeta->getSaldo());
        $this->assertEquals(1400, $tarjeta->getSaldoPendiente());
    }

    public function testRecargaConExcedenteDespuesDeViaje()
    {
        $tiempo = new TiempoFalso;
        $tarjeta = new Tarjeta(1,$tiempo);
        $tarjeta->recargar(4000);
        $tarjeta->recargar(4000);
        
        $tarjeta->descontar($this->boletoInterUrbano);
        $this->assertEquals(6600, $tarjeta->getSaldo());
        $this->assertEquals(1216 , $tarjeta->getSaldoPendiente());
    } 
}
?>