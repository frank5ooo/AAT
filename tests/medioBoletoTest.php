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
    // private $montosValidos = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 
    // 800, 900, 1000, 1100, $boletoMedio0, 1300, 1400, 1500, 2000, 
    // 2500, 3000, 3500, 4000];

    private $boleto = 120;

    public function testPagarConMedioBoletoConSaldo()
    {
        $boletoMedio =  $this->boleto/2;
        $tiempo = new TiempoFalso;
        $tiempo->avanzar(300);

        $tarjeta = new MedioBoleto($tiempo); 
        $tarjeta->recargar(1000);
        
        $resultado = $tarjeta->descontarMedioBoleto();

        echo "precio" . $tarjeta->getPrecio(). "\n";
        echo "Monto de recarga: $1000\n";

        echo "Saldo después del descuento: " . $tarjeta->getSaldoMedioBoleto() . "\n";
        echo "Resultado del descuento: " . ($resultado ? 'Éxito' : 'Fallo') . "\n\n";

        $this->assertTrue($resultado);
        $this->assertEquals(1000 - $boletoMedio, $tarjeta->getSaldoMedioBoleto());
    }

    public function testPagarConMedioBoletoSinSaldo()
    {
        $boletoMedio =  $this->boleto/2;
        $tiempo = new TiempoFalso;
        $tiempo->avanzar(300);

        $tarjeta = new MedioBoleto($tiempo); 
        $tarjeta->recargar(0);
        $resultado = $tarjeta->descontarMedioBoleto();

        if (0 >= ($boletoMedio))
        {
            $this->assertTrue($resultado);
            $this->assertEquals(0 - $boletoMedio, $tarjeta->getSaldoMedioBoleto());
        }
        elseif (0 >= -151.84)
        {
            echo "Saldo::" . $tarjeta->getSaldoMedioBoleto() . "\n";
            echo "Resultado del descuento: " . ($resultado ? 'Éxito' : 'Fallo') . "\n\n";

            $this->assertTrue($resultado);
            $this->assertEquals(0 - ($this->boleto), $tarjeta->getSaldoMedioBoleto());
        } 
        else{
            $this->assertFalse($resultado);
            $this->assertEquals(0, $tarjeta->getSaldoMedioBoleto());
        }
    }

    public function testLimiteDeViajesPorDia() 
    {
        $tiempo = new TiempoFalso;
        $tiempo->avanzar(300);

        $tarjeta = new MedioBoleto($tiempo); 
        $tarjeta->recargar(2000);
        
        // Simular 4 viajes en el mismo día

        $tiempo->avanzar(300);
        //echo "viajes 1hoy". $tarjeta->viajesHoy;
        $this->assertTrue($tarjeta->descontarMedioBoleto());    // Viaje 1

        //echo "viajes hoy2". $tarjeta->viajesHoy;
        $tiempo->avanzar(300);
        $this->assertTrue($tarjeta->descontarMedioBoleto());    // Viaje 2

        //echo "viajes hoy3". $tarjeta->viajesHoy;
        $tiempo->avanzar(300);
        $this->assertTrue($tarjeta->descontarMedioBoleto());    // Viaje 3
        
        //echo "viajes hoy4". $tarjeta->viajesHoy;
        $tiempo->avanzar(300);
        $this->assertTrue($tarjeta->descontarMedioBoleto());    // Viaje 4
        
        //echo "viajes hoy5". $tarjeta->viajesHoy;
        $tiempo->avanzar(300);
        // Intentar realizar un quinto viaje
        $this->assertTrue($tarjeta->descontarMedioBoleto()); // Quinto viaje
        $this->assertEquals(2000 - $this->boleto, $tarjeta->getSaldoMedioBoleto());

        // Verificar que se cobra el precio completo para el quinto viaje
        $this->expectOutputString("Ha alcanzado el límite de 4 viajes con medio boleto hoy. Se le cobrará el precio completo.\n");
    }
    
    public function testViajandoEnMenosDe5Minutos() 
    {
        $tiempo = new TiempoFalso;

        $tarjeta = new MedioBoleto($tiempo); 
        $tarjeta->recargar(2000);

        $tiempo->avanzar(300);
        $this->assertTrue($tarjeta->descontarMedioBoleto());    // Viaje 1

        $tiempo->avanzar(-300);
        $tiempo->avanzar(200);
        $this->assertFalse($tarjeta->descontarMedioBoleto());    // Viaje 2 no se podra

        $tiempo->avanzar(-200);
        $tiempo->avanzar(500);
        $this->assertTrue($tarjeta->descontarMedioBoleto());    // Viaje 3

        $tiempo->avanzar(-500);
        $tiempo->avanzar(400);
        $this->assertTrue($tarjeta->descontarMedioBoleto());    // Viaje 4

        $tiempo->avanzar(-400);
        $tiempo->avanzar(400);
        $this->assertTrue($tarjeta->descontarMedioBoleto());    // Viaje 5

        $tiempo->avanzar(-400);
        $tiempo->avanzar(300);
        $this->assertTrue($tarjeta->descontarMedioBoleto());    // Viaje 6
        $this->assertEquals(2000 - $this->boleto, $tarjeta->getSaldoMedioBoleto());

    }
}
?>