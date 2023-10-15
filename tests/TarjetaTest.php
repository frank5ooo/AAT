<?php

namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\tarjeta;
use TrabajoSube\colectivo;
use TrabajoSube\boleto;


class TarjetaTest extends TestCase {
    private $montosValidos = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 
                800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 
                2500, 3000, 3500, 4000];

    private $boleto = 120;
    public function testRecargar() 
    {
        $tarjeta = new Tarjeta(0);
    
        foreach ($this->montosValidos as $monto) 
        {        
            $saldoInicial = $tarjeta->saldo;
    
            $tarjeta->recargar($monto);
    
            $saldoEsperado = min($saldoInicial + $monto, 6600);
    
            $this->assertEquals($saldoEsperado, $tarjeta->saldo);
        }
        
    }

    public function testDescontarConSaldo()
    {      
        $tarjeta = new tarjeta(2000);
        
        if(2000 >= $this->boleto)
        {
            $tarjeta->descontar($this->boleto);

            $this->assertEquals(2000-$this->boleto, $tarjeta->saldo);
            $this->assertTrue($tarjeta->descontar($this->boleto));
        }
    }
    public function testDescontarSinSaldo()
    {
        $tarjeta = new Tarjeta(0);
        $tarjeta->recargar(150);

        $nuevoSaldo = $tarjeta->getSaldo();
        $resultado = $tarjeta->descontar($this->boleto);
        $this->assertTrue($resultado);
        $this->assertEquals($nuevoSaldo - $this->boleto, $tarjeta->getSaldo());

        $nuevoSaldo = $tarjeta->getSaldo();
        $resultado = $tarjeta->descontar($this->boleto);
        $this->assertTrue($resultado);
        $this->assertEquals($nuevoSaldo - $this->boleto, $tarjeta->getSaldo());
        
        $nuevoSaldo = $tarjeta->getSaldo();
        $resultado = $tarjeta->descontar($this->boleto);
        $this->assertTrue($resultado);
        $this->assertEquals($nuevoSaldo - $this->boleto, $tarjeta->getSaldo());

        $nuevoSaldo = $tarjeta->getSaldo();
        $resultado = $tarjeta->descontar($this->boleto);
        $this->assertFalse($resultado);
        $this->assertEquals($nuevoSaldo, $tarjeta->getSaldo());
    }

    public function testRecargaConExcedente()
    {
        $tarjeta = new Tarjeta(5000);
        $tarjeta->recargar(2500);  // Se cargan 2500 por lo que quedará 5000 + 2500 - 6600 = 900 en saldo
    
        $this->assertEquals(6600, $tarjeta->saldo);
        $this->assertEquals(900, $tarjeta->getSaldoPendiente());
    }

    public function testRecargaConExcedenteDespuesDeViaje()
    {
        $tarjeta = new Tarjeta(5000);
        $tarjeta->recargar(2000); //antes del viaje hay 400 en saldo pendiente, despues del mismo hay 280
        
        $tarjeta->descontar($this->boleto);
        $this->assertEquals(6600, $tarjeta->saldo);
        $this->assertEquals(280 , $tarjeta->getSaldoPendiente());
    } 
}
