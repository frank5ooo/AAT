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

    public function testRecargaConExcedente()
    {
        $tiempo = new TiempoFalso;
        $tarjeta = new Tarjeta(1,$tiempo);
        $tarjeta->recargar(4000);  
        $tarjeta->recargar(4000);  
        
        //echo"saldo". $tarjeta->getSaldo();
        $this->assertEquals(6600, $tarjeta->getSaldo());
       // $this->assertEquals(1400, $tarjeta->saldoPendiente);
    }

    public function testRecargaConExcedenteDespuesDeViaje()
    {
        $tiempo = new TiempoFalso;
        $tarjeta = new Tarjeta(1,$tiempo);
        $tarjeta->recargar(4000);
        $tarjeta->recargar(4000);
        
        $tarjeta->descontar($this->boletoUrbano);
        $this->assertEquals(6600, $tarjeta->getSaldo());
        //$this->assertEquals(1280 , $tarjeta->saldoPendiente);
    } 

    public function testUnViaje()
    {
        $tiempo = new TiempoFalso;
        $tarjeta = new Tarjeta(1,$tiempo);
        $tarjeta->recargar(4000);
        
        $tarjeta->descontar($this->boletoUrbano);

        $this->assertEquals(1,$tarjeta->getCantViajesEnElMes());
        $this->assertEquals(date('m', $tiempo->time()),$tarjeta->getMesActual());
    }

    public function testViajeDescuento20PorCiento()
    {
        $tiempo = new TiempoFalso;
        $tarjeta = new Tarjeta(1,$tiempo);
        $tarjeta->recargar(4000);
        
        for($i=0; $i<31; $i++)
        {
            $tarjeta->descontar($this->boletoUrbano);
        }
        // echo"\nprecioTestt:".$tarjeta->getCantViajesEnElMes();
        // echo"\nprecioTestt:".$tarjeta->getPrecio();

        $this->assertEquals(31, $tarjeta->getCantViajesEnElMes());
        $this->assertEquals(96, $tarjeta->getPrecio());
    }

    public function testViajeDescuento25PorCiento()
    {
        $tiempo = new TiempoFalso;
        $tarjeta = new Tarjeta(1,$tiempo);
        $tarjeta->recargar(40000);
        
        for($i=0; $i<90; $i++)
        {
            $tarjeta->descontar($this->boletoUrbano);
        }
        // echo"\nViajesTestt:".$tarjeta->getCantViajesEnElMes();
        // echo"\nprecioTestt:".$tarjeta->getPrecio();

        $this->assertEquals(90, $tarjeta->getCantViajesEnElMes());
        $this->assertEquals(90, $tarjeta->getPrecio());
    }

    public function testCambioDeMes()
    {
        $tiempo = new TiempoFalso;
        $tarjeta = new Tarjeta(1,$tiempo);
        $tarjeta->recargar(40000);
        
        for($i=0; $i<40; $i++)
        {
            $tarjeta->descontar($this->boletoUrbano);
        }
        // echo"\nViajesTestt:".$tarjeta->getCantViajesEnElMes();
        // echo"\nprecioTestt:".$tarjeta->getPrecio();
        $this->assertEquals(40, $tarjeta->getCantViajesEnElMes());
        $this->assertEquals(96, $tarjeta->getPrecio());
        $this->assertEquals(date('m', $tiempo->time()), $tarjeta->getMesActual());
        //echo "mes". date('m', $tiempo->time());

        $tiempo->avanzar(32*86400);

        $tarjeta->descontar($this->boletoUrbano);
        //echo "\nPRECIOOOOO".  $tarjeta->getPrecio();

        $this->assertEquals(1, $tarjeta->getCantViajesEnElMes());
        $this->assertEquals(date('m', $tiempo->time()), $tarjeta->getMesActual());

        $this->assertEquals(120, $tarjeta->getPrecio());
    }
}
?>