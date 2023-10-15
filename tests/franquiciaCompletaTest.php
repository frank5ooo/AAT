<?php

namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\franquiciacompleta;
use TrabajoSube\TiempoFalso;

class franquiciaCompletaTest extends TestCase 
{
    private $boleto = 120;
    
    public function testDescontarFranquiciaCompleta()
    { 
        $tiempo = new TiempoFalso;
        $tarjeta = new franquiciacompleta($tiempo); 
        $tarjeta->recargar(600);
        
        for($i=0;$i<5;$i++)
        {
            $tarjeta->descontarFranquiciaCompleta($this->boleto);
        }
        $this->assertEquals(240, $tarjeta->getSaldo());
    }

    public function testPagandoUltimoViaje()
    { 
        $tiempo = new TiempoFalso;
        $tarjeta = new franquiciacompleta($tiempo); 
        $tarjeta->recargar(4000);
        
        $this->assertEquals(True,$tarjeta->descontarFranquiciaCompleta($this->boleto));
        $this->assertEquals(4000, $tarjeta->getSaldo());
        $this->assertEquals(1, $tarjeta->getCantViajesGratis());

        $this->assertEquals(True,$tarjeta->descontarFranquiciaCompleta($this->boleto));
        $this->assertEquals(4000, $tarjeta->getSaldo());
        $this->assertEquals(0, $tarjeta->getCantViajesGratis());


        $this->assertEquals(True,$tarjeta->descontarFranquiciaCompleta($this->boleto));
        $this->assertEquals(3880, $tarjeta->getSaldo());
    }

    public function testViajesGratisDespuesDeUnNuevoDia() {
        $inicio = strtotime('today'); // Fecha y hora inicial
        $tiempoFalso = new TiempoFalso($inicio);
        $tarjeta = new FranquiciaCompleta($tiempoFalso);
        
        // Realizar dos viajes gratuitos en un día
        $this->assertTrue($tarjeta->descontarFranquiciaCompleta(0)); // Primer viaje gratis
        $this->assertTrue($tarjeta->descontarFranquiciaCompleta(0)); // Segundo viaje gratis
        $this->assertEquals(0, $tarjeta->getCantViajesGratis());

        // Simular un nuevo día
        $tiempoFalso->avanzar(86400); // Avanzar un día 

        // Realizar un viaje en el nuevo día (debe ser gratis nuevamente)
        $this->assertTrue($tarjeta->descontarFranquiciaCompleta(0)); // Tercer viaje gratis
    }
}

