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

    // public function testPagarConMedioBoletoConSaldo()
    // {
    //     $boletoMedio =  $this->boleto/2;
    //     $tiempo = new TiempoFalso();

    //     $tarjeta = new medioboleto($tiempo); 
    //     $tarjeta->recargar(1000);
    //     $resultado = $tarjeta->descontarMedioBoleto($this->boleto);

    //     echo "precio" . $tarjeta->getPrecio(). "\n" ;
    //     echo "Monto de recarga: $1000\n";

    //     echo "Saldo después del descuento: " . $tarjeta->setSaldoMedioBoleto() . "\n";
    //     echo "Resultado del descuento: " . ($resultado ? 'Éxito' : 'Fallo') . "\n\n";

    //     $this->assertTrue($resultado);
    //     $this->assertEquals(1000 - $boletoMedio, $tarjeta->setSaldoMedioBoleto());
    // }

    public function testPagarConMedioBoletoSinSaldo()
    {
        $boletoMedio =  $this->boleto /2;
        $tiempo = new TiempoFalso;

        $tarjeta = new MedioBoleto($tiempo); 
        $tarjeta->recargar(0);
        $resultado = $tarjeta->descontarMedioBoleto($this->boleto);

        if (0 >= ($boletoMedio)){
            $this->assertTrue($resultado);
            $this->assertEquals(0 - $boletoMedio, $tarjeta->setSaldoMedioBoleto());
        }
        elseif (0 >= -151.84){

            echo "Saldo::" . $tarjeta->setSaldoMedioBoleto() . "\n";
            echo "Resultado del descuento: " . ($resultado ? 'Éxito' : 'Fallo') . "\n\n";

            $this->assertTrue($resultado);
            $this->assertEquals(0 - ($this->boleto), $tarjeta->setSaldoMedioBoleto());
        } 
        else{
            $this->assertFalse($resultado);
            $this->assertEquals(0, $tarjeta->setSaldoMedioBoleto());
        }
    }



// public function testLimiteDeViajesPorDia() {
//         $medioBoleto = new MedioBoleto(2000);
        
//         // Simular 4 viajes en el mismo día
//         $this->assertTrue($medioBoleto->descontar(120));    //viaje 1
//         $this->assertEquals(1940 , $medioBoleto->getSaldo());                
//         $medioBoleto->setUltimoTiempo();

//         $this->assertTrue($medioBoleto->descontar(120));    //viaje 2
//         $this->assertEquals(1880 , $medioBoleto->getSaldo());  
//         $medioBoleto->setUltimoTiempo();

//         $this->assertTrue($medioBoleto->descontar(120));    //viaje 3
//         $this->assertEquals(1820 , $medioBoleto->getSaldo());  
//         $medioBoleto->setUltimoTiempo();

//         $this->assertTrue($medioBoleto->descontar(120));    //viaje 4
//         $this->assertEquals(1760 , $medioBoleto->getSaldo());  
//         $medioBoleto->setUltimoTiempo();
        
//         // Simular un quinto viaje
//         $this->assertTrue($medioBoleto->descontar(120)); // Quinto viaje
        
//         // Verificar que se cobra el precio completo para el quinto viaje
//         $this->expectOutputString("Ha alcanzado el límite de 4 viajes con medio boleto hoy. Se le cobrará el precio completo.\n");
//     }

//     public function testSinPasarLimiteDeViajesPorDia() {
//         $medioBoleto = new MedioBoleto(2000);
        
//         // Simular 4 viajes en el mismo día
//         $this->assertTrue($medioBoleto->descontar(120));    //viaje 1
//         $this->assertEquals(1940 , $medioBoleto->getSaldo());                
//         $medioBoleto->setUltimoTiempo();

//         $this->assertTrue($medioBoleto->descontar(120));    //viaje 2
//         $this->assertEquals(1880 , $medioBoleto->getSaldo());  
//         $medioBoleto->setUltimoTiempo();

//         $this->assertTrue($medioBoleto->descontar(120));    //viaje 3
//         $this->assertEquals(1820 , $medioBoleto->getSaldo());  
//         $medioBoleto->setUltimoTiempo();
        
//         // Simular un cuarto viaje
//         $this->assertTrue($medioBoleto->descontar(120)); // viaje 4
//         $this->assertEquals(1760 , $medioBoleto->getSaldo());  
        
//     }
}
?>