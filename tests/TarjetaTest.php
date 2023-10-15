<?php

namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\tarjeta;
use TrabajoSube\colectivo;
use TrabajoSube\boleto;
use TrabajoSube\franquiciacompleta;
use TrabajoSube\medioboleto;
use TrabajoSube\tiempoFalso;


class TarjetaTest extends TestCase {
    private $montosValidos = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 
                800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 
                2500, 3000, 3500, 4000];

    private $boleto = 120;
    public function testRecargar() 
    {
        $tiempo = new TiempoFalso;
        
            foreach ($this->montosValidos as $monto) 
            {        
                $tarjeta = new Tarjeta($tiempo);

                $saldoInicial = $tarjeta->getSaldo();
        
                $tarjeta->recargar($monto);
        
                $saldoEsperado = min($saldoInicial + $monto, 6600);
        
                $this->assertEquals($saldoEsperado, $tarjeta->getSaldo());
            }
        
    }

    public function testDescontar()
    {
        $tiempo = new TiempoFalso;
            
        foreach ($this->montosValidos as $prueba) 
        {

            $tarjeta = new Tarjeta($tiempo);

            $tarjeta->recargar($prueba);
            
            $resultado = $tarjeta->descontar($this->boleto);


                $this->assertTrue($resultado);
                $this->assertEquals($prueba - $this->boleto, $tarjeta->getSaldo());

        }
    }

    public function testDescontarSinSaldo()
    {
            $tiempo = new TiempoFalso;

            $tarjeta = new Tarjeta($tiempo);

            $tarjeta->recargar(150);
            
            $tarjeta->descontar($this->boleto);   //viaje 1

            $resultado = $tarjeta->descontar($this->boleto);   //viaje 2

            $this->assertTrue($resultado);
            $this->assertEquals(-90, $tarjeta->getSaldo());

            $resultado = $tarjeta->descontar($this->boleto);   //viaje 3

            $this->assertTrue($resultado);
            $this->assertEquals(-210, $tarjeta->getSaldo());
           
            $resultado = $tarjeta->descontar($this->boleto);   //viaje 4

            $this->assertFalse($resultado);
        
    }

    public function testRecargaConExcedente()
    {
        $tiempo = new TiempoFalso;
        $tarjeta = new Tarjeta($tiempo);
        $tarjeta->recargar(4000);  
        $tarjeta->recargar(4000);  
    
        $this->assertEquals(6600, $tarjeta->getSaldo());
       // $this->assertEquals(1400, $tarjeta->saldoPendiente);
    }

    public function testRecargaConExcedenteDespuesDeViaje()
    {
        $tiempo = new TiempoFalso;
        $tarjeta = new Tarjeta($tiempo);
        $tarjeta->recargar(4000);
        $tarjeta->recargar(4000);
        
        $tarjeta->descontar($this->boleto);
        $this->assertEquals(6600, $tarjeta->getSaldo());
        //$this->assertEquals(1280 , $tarjeta->saldoPendiente);
    } 
}
?>