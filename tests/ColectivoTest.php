<?php

namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\tarjeta;
use TrabajoSube\colectivo;
use TrabajoSube\boleto;


class ColectivoTest extends TestCase {
    private $montosValidos = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 
                800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 
                2500, 3000, 3500, 4000];

    private $montosDePrueba = [-120, 1, 500, 1000,6600];

    private $boleto = 120;
    public function testRecargar() 
    {
        foreach ($this->montosDePrueba as $prueba)
        {
            $tarjeta = new Tarjeta($prueba);
        
            foreach ($this->montosValidos as $monto) 
            {        
                $saldoInicial = $tarjeta->saldo;
        
                $tarjeta->recargar($monto);
        
                $saldoEsperado = min($saldoInicial + $monto, 6600);
        
                $this->assertEquals($saldoEsperado, $tarjeta->saldo);
            }
        }
    }

    public function testDescontarConSaldo()
    {      
        
        foreach ($this->montosDePrueba as $prueba)
        {
            $tarjeta = new tarjeta($prueba);
            
            if($prueba >= $this->boleto)
            {
                $tarjeta->descontar($this->boleto);

                $this->assertEquals($prueba-$this->boleto, $tarjeta->saldo);
            }
        }
    }

    public function testDescontarSinSaldo()
    {
        foreach ($this->montosDePrueba as $pruebaSaldo) 
        {
            $tarjeta = new Tarjeta($pruebaSaldo);
            
            $resultado = $tarjeta->descontar($this->boleto);

            if ($pruebaSaldo >= $this->boleto) 
            {
                $this->assertTrue($resultado);
                $this->assertEquals($pruebaSaldo - $this->boleto, $tarjeta->getSaldo());
            } 
            elseif ($pruebaSaldo >= -91.84) 
            {
                $this->assertTrue($resultado);
                $this->assertEquals($pruebaSaldo - $this->boleto, $tarjeta->getSaldo());
            } 
            else 
            {
                $this->assertFalse($resultado);
                $this->assertEquals($pruebaSaldo, $tarjeta->getSaldo());
            }
        }
    }

    public function testRecargaConExcedente()
    {
        $tarjeta = new Tarjeta(5000);
        $tarjeta->recargar(2000);  //se cargan 2000 por lo que quedaran 400 de saldo pendiente
        
        $this->assertEquals(6600, $tarjeta->saldo);
        $this->assertEquals(400, $tarjeta->saldoPendiente);
    }

   /* public function testRecargaDespuesDeViaje()
    {
        $tarjeta = new Tarjeta(5000);
        $tarjeta->recargar(2000); //antes del viaje hay 400 en saldo pendiente, despues del mismo hay 280
        
        $tarjeta->descontar($this->boleto);
        $this->assertEquals(6600, $tarjeta->saldo);
        $this->assertEquals(280 , $tarjeta->saldoPendiente);
    } */
}
