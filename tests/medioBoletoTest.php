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

        $tarjeta = new MedioBoleto(1,$tiempo); 
        $tarjeta->recargar(1000);

        $tiempo->avanzar(3600*7); //se avanza la hora para que este en un horario aceptable
        $resultado = $tarjeta->descontarMedioBoleto($this->boleto);

        // echo"TIEMPO". (date("l G", $tiempo->time()));

        echo "precio" . $tarjeta->getPrecio(). "\n";
        //echo "Monto de recarga: $1000\n";

        echo "Saldo después del descuento: " . $tarjeta->getSaldo() . "\n";
        echo "Resultado del descuento: " . ($resultado ? 'Éxito' : 'Fallo') . "\n\n";

        $this->assertTrue($resultado);
        $this->assertEquals(1000 - $boletoMedio, $tarjeta->getSaldo());
    }

    public function testPagarConMedioBoletoSinSaldo()
    {
        $tiempo = new TiempoFalso;

        $tarjeta = new MedioBoleto(1,$tiempo); 
        $tarjeta->recargar(0);
        
        $tiempo->avanzar(3600*7);
        $resultado = $tarjeta->descontarMedioBoleto($this->boleto);

        echo "Saldo::" . $tarjeta->getSaldo() . "\n";
        echo "Resultado del descuento: " . ($resultado ? 'Éxito' : 'Fallo') . "\n\n";

        $this->assertTrue($resultado);
        $this->assertEquals(0 - ($this->boleto), $tarjeta->getSaldo());
    }

    public function testNoPagarConMedioBoletoSinSaldo()
    {
        $tiempo = new TiempoFalso;

        $tarjeta = new MedioBoleto(1,$tiempo); 
        $tarjeta->recargar(0);

        $resultado = $tarjeta->descontarMedioBoleto($this->boleto);
        $resultado = $tarjeta->descontarMedioBoleto($this->boleto);
        $resultado = $tarjeta->descontarMedioBoleto($this->boleto);

        $this->assertFalse($resultado);  
    }

    public function testLimiteDeViajesPorDia() 
    {
        $tiempo = new TiempoFalso;
        $boletoMedio =  $this->boleto/2;

        $tarjeta = new MedioBoleto(1,$tiempo); 
        $tarjeta->recargar(2000);

        $tiempo->avanzar(3600*7);

        // Simular 4 viajes en el mismo día

        $this->assertTrue($tarjeta->descontarMedioBoleto($this->boleto));    // Viaje 1
        $this->assertEquals(3, $tarjeta->GetCantViajesMedioBoleto());
        $this->assertEquals(2000 - $boletoMedio, $tarjeta->getSaldo());

        $tiempo->avanzar(300);


        $this->assertTrue($tarjeta->descontarMedioBoleto($this->boleto));    // Viaje 2
        $this->assertEquals(2, $tarjeta->GetCantViajesMedioBoleto());
        $this->assertEquals(2000 - ($boletoMedio*2), $tarjeta->getSaldo());

        $tiempo->avanzar(300);
        $this->assertTrue($tarjeta->descontarMedioBoleto($this->boleto));    // Viaje 3
        $this->assertEquals(1, $tarjeta->GetCantViajesMedioBoleto());
        $this->assertEquals(2000 - ($boletoMedio*3), $tarjeta->getSaldo());

        $tiempo->avanzar(300);
        $this->assertTrue($tarjeta->descontarMedioBoleto($this->boleto));    // Viaje 4
        $this->assertEquals(0, $tarjeta->GetCantViajesMedioBoleto());
        $this->assertEquals(2000 - ($boletoMedio*4), $tarjeta->getSaldo());

        $tiempo->avanzar(3600*7);
        $tiempo->avanzar(300);
        $this->assertTrue($tarjeta->descontarMedioBoleto($this->boleto)); // Viaje 5
        $this->assertEquals(0, $tarjeta->GetCantViajesMedioBoleto());
        $this->assertEquals(2000 - ($boletoMedio*4)-120, $tarjeta->getSaldo());
    }
    
    public function testViajandoEnMenosDe5Minutos() 
    {
        $tiempo = new TiempoFalso;

        $tarjeta = new MedioBoleto(1,$tiempo); 
        $tarjeta->recargar(2000);
        $tiempo->avanzar(3600*7);

        //echo "toempo" .$tiempo->time();

        $this->assertTrue($tarjeta->descontarMedioBoleto($this->boleto));    // Viaje 1 no se podra
        $this->assertEquals(1940,$tarjeta->getSaldo());


        $tiempo->avanzar(200);
       // echo "toempo2" . $tiempo->time();
        $this->assertFalse($tarjeta->descontarMedioBoleto($this->boleto));    // Viaje 2 se podra
        $this->assertEquals(1940,$tarjeta->getSaldo());
    }
    
    public function testCambioDeDia()
    {
        $tiempo = new TiempoFalso;
        $boletoMedio =  $this->boleto/2;

        $tarjeta = new MedioBoleto(1,$tiempo); 
        $tarjeta->recargar(2000);
        $tiempo->avanzar(3600*7);

        // Simular 4 viajes en el mismo día

        $this->assertTrue($tarjeta->descontarMedioBoleto($this->boleto));    // Viaje 1
        $this->assertEquals(3, $tarjeta->GetCantViajesMedioBoleto());
        $this->assertEquals(2000 - $boletoMedio, $tarjeta->getSaldo());

        $tiempo->avanzar(300);
        $this->assertTrue($tarjeta->descontarMedioBoleto($this->boleto));    // Viaje 2
        $this->assertEquals(2, $tarjeta->GetCantViajesMedioBoleto());
        $this->assertEquals(2000 - ($boletoMedio*2), $tarjeta->getSaldo());

        $tiempo->avanzar(300);
        $this->assertTrue($tarjeta->descontarMedioBoleto($this->boleto));    // Viaje 3
        $this->assertEquals(1, $tarjeta->GetCantViajesMedioBoleto());
        $this->assertEquals(2000 - ($boletoMedio*3), $tarjeta->getSaldo());

        $tiempo->avanzar(300);
        $this->assertTrue($tarjeta->descontarMedioBoleto($this->boleto));    // Viaje 4
        $this->assertEquals(0, $tarjeta->GetCantViajesMedioBoleto());
        $this->assertEquals(2000 - ($boletoMedio*4), $tarjeta->getSaldo());

        $tiempo->avanzar(300);
        $this->assertTrue($tarjeta->descontarMedioBoleto($this->boleto)); // Viaje 5
        $this->assertEquals(0, $tarjeta->GetCantViajesMedioBoleto());
        $this->assertEquals(2000 - ($boletoMedio*4)-120, $tarjeta->getSaldo());

        //Cambio de dia

        $tiempo->avanzar(86400);
        $this->assertTrue($tarjeta->descontarMedioBoleto($this->boleto));    // Viaje 1
        $this->assertEquals(3, $tarjeta->GetCantViajesMedioBoleto());
        $this->assertEquals(2000 - ($boletoMedio*4)-120-60, $tarjeta->getSaldo());

    }
}
?>