<?php

namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\tarjeta;
use TrabajoSube\tiempoFalso;


class TarjetaTest extends TestCase 
{
    private $montosValidos = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 
                800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 
                2500, 3000, 3500, 4000];


    private $boleto = 120;
    public function testRecargar() 
    {   
        $inicio = strtotime('today'); // Fecha y hora inicial

        $tiempo = new tiempoFalso($inicio);
        $tarjeta = new Tarjeta($tiempo);
    
        foreach ($this->montosValidos as $monto) 
        {        
            $saldoInicial = $tarjeta->saldo;
    
            $tarjeta->recargar($monto);
    
            $saldoEsperado = min($saldoInicial + $monto, 6600);
    
            $this->assertEquals($saldoEsperado, $tarjeta->saldo);
        }
        
    }

    // public function testDescontarConSaldo()
    // {      
        
    //     foreach ($this->montosDePrueba as $prueba)
    //     {
    //         $tarjeta = new tarjeta($prueba);
            
    //         if($prueba >= $this->boleto)
    //         {
    //             $tarjeta->descontar($this->boleto);

    //             $this->assertEquals($prueba-$this->boleto, $tarjeta->saldo);
    //         }
    //     }
    // }
    // public function testDescontarSinSaldo()
    // {
    //     foreach ($this->montosDePrueba as $pruebaSaldo) 
    //     {
    //         $tarjeta = new Tarjeta($pruebaSaldo);
            
    //         $resultado = $tarjeta->descontar($this->boleto);

    //         if ($pruebaSaldo >= $this->boleto)      //pagar con saldo
    //         {
    //             $this->assertTrue($resultado);
    //             $this->assertEquals($pruebaSaldo - $this->boleto, $tarjeta->getSaldo());
    //             $this->assertEquals(0, $tarjeta->viajePlus);
    //         } 
    //         elseif ($pruebaSaldo >= -91.84)     //pagar con saldo negativo pero mayor al menor posible
    //         {
    //             $this->assertTrue($resultado);
    //             $this->assertEquals($pruebaSaldo - $this->boleto, $tarjeta->getSaldo());
    //             $this->assertEquals($tarjeta->viajePlus<=2, $tarjeta->viajePlus);
    //         } 
    //         else                                // no tiene ni viaje plus
    //         {
    //             $this->assertFalse($resultado);
    //             $this->assertEquals($pruebaSaldo, $tarjeta->getSaldo());
    //             $this->assertEquals($tarjeta->viajePlus>2, $tarjeta->viajePlus);

    //         }
    //     }
    // }

    // public function testRecargaConExcedente()
    // {
    //     $tarjeta = new Tarjeta(5000);
    //     $tarjeta->recargar(2000);  // Se cargan 2400 por lo que quedará 5000 + 2400 - 6000 = 800 en saldo
    
    //     $this->assertEquals(6600, $tarjeta->saldo);
    //     $this->assertEquals(400, $tarjeta->saldoPendiente);
    // }
} 

