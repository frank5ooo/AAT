<?php
namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\tarjeta;
use TrabajoSube\colectivo;
use TrabajoSube\boleto;
use TrabajoSube\franquiciacompleta;
use TrabajoSube\medioboleto;
use TrabajoSube\tiempoFalso;


 class MedioBoletoTest extends TestCase {
    private $montosValidos = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 
    800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 
    2500, 3000, 3500, 4000];


    private $boleto = 120;

    public function testPagarConMedioBoletoConSaldo()
    {
        $boletoMedio =  $this->boleto /2;
        $tiempo = new TiempoFalso;

        foreach ($this->montosValidos as $prueba){

            $tarjeta = new MedioBoleto($tiempo); 
            $tarjeta->recargar($prueba);
            $resultado = $tarjeta->descontar($this->boleto);

            echo "Monto de recarga: $prueba\n";
            echo "Saldo después del descuento: " . $tarjeta->getSaldo() . "\n";
            echo "Resultado del descuento: " . ($resultado ? 'Éxito' : 'Fallo') . "\n\n";
    

            $this->assertTrue($resultado);
            $this->assertEquals($prueba - $boletoMedio, $tarjeta->getSaldo());
            
        }

    }
/*
    public function testPagarConMedioBoletoSinSaldo()
    {
        $boletoMedio =  $this->boleto /2;
        $tiempo = new TiempoFalso;

        foreach ($this->montosValidos as $prueba){

            $tarjeta = new MedioBoleto($tiempo); 
            $tarjeta->recargar($prueba);
            $resultado = $tarjeta->descontar($this->boleto);

            if ($prueba >= ($boletoMedio)){
                $this->assertTrue($resultado);
                $this->assertEquals($prueba - $boletoMedio, $tarjeta->getSaldo());
            }
            elseif ($prueba >= -151.84){
                $this->assertTrue($resultado);
                $this->assertEquals($prueba - ($this->boleto), $tarjeta->getSaldo());
            } 
            else{
                $this->assertFalse($resultado);
                $this->assertEquals($prueba, $tarjeta->getSaldo());
            }
        }

    }



public function testLimiteDeViajesPorDia() {
        $medioBoleto = new MedioBoleto(2000);
        
        // Simular 4 viajes en el mismo día
        $this->assertTrue($medioBoleto->descontar(120));    //viaje 1
        $this->assertEquals(1940 , $medioBoleto->getSaldo());                
        $medioBoleto->setUltimoTiempo();

        $this->assertTrue($medioBoleto->descontar(120));    //viaje 2
        $this->assertEquals(1880 , $medioBoleto->getSaldo());  
        $medioBoleto->setUltimoTiempo();

        $this->assertTrue($medioBoleto->descontar(120));    //viaje 3
        $this->assertEquals(1820 , $medioBoleto->getSaldo());  
        $medioBoleto->setUltimoTiempo();

        $this->assertTrue($medioBoleto->descontar(120));    //viaje 4
        $this->assertEquals(1760 , $medioBoleto->getSaldo());  
        $medioBoleto->setUltimoTiempo();
        
        // Simular un quinto viaje
        $this->assertTrue($medioBoleto->descontar(120)); // Quinto viaje
        
        // Verificar que se cobra el precio completo para el quinto viaje
        $this->expectOutputString("Ha alcanzado el límite de 4 viajes con medio boleto hoy. Se le cobrará el precio completo.\n");
    }

    public function testSinPasarLimiteDeViajesPorDia() {
        $medioBoleto = new MedioBoleto(2000);
        
        // Simular 4 viajes en el mismo día
        $this->assertTrue($medioBoleto->descontar(120));    //viaje 1
        $this->assertEquals(1940 , $medioBoleto->getSaldo());                
        $medioBoleto->setUltimoTiempo();

        $this->assertTrue($medioBoleto->descontar(120));    //viaje 2
        $this->assertEquals(1880 , $medioBoleto->getSaldo());  
        $medioBoleto->setUltimoTiempo();

        $this->assertTrue($medioBoleto->descontar(120));    //viaje 3
        $this->assertEquals(1820 , $medioBoleto->getSaldo());  
        $medioBoleto->setUltimoTiempo();
        
        // Simular un cuarto viaje
        $this->assertTrue($medioBoleto->descontar(120)); // viaje 4
        $this->assertEquals(1760 , $medioBoleto->getSaldo());  
        
    }*/
 }
?>