<?php

namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\franquiciacompleta; 
use TrabajoSube\tiempoFalso; 

class franquiciaCompletaTest extends TestCase 
{
    private $boleto = 120;

    public function testDescontarFranquiciaCompleta()
    { 
        $inicio = strtotime('today'); // Fecha y hora inicial
        $tiempo = new tiempoFalso($inicio);
        $tarjeta = new franquiciacompleta(1,$tiempo); 
        $tarjeta->recargar(600);
        $tiempo->avanzar(3600*7);

        for($i=0; $i<5; $i++)
        {
            $tarjeta->descontarFranquiciaCompleta($this->boleto);
        }
        $this->assertEquals(240, $tarjeta->getSaldo());
    }

    public function testPagandoUltimoViaje()
    { 
        $inicio = strtotime('today'); // Fecha y hora inicial
        $tiempo = new tiempoFalso($inicio);
        $tarjeta = new franquiciacompleta(1,$tiempo); 
        $tarjeta->recargar(4000);
        $tiempo->avanzar(3600*7);

        $this->assertEquals(True,$tarjeta->descontarFranquiciaCompleta($this->boleto));
        $this->assertEquals(4000, $tarjeta->getSaldo());
        $this->assertEquals(1, $tarjeta->getCantViajesGratis());

        $this->assertEquals(True,$tarjeta->descontarFranquiciaCompleta($this->boleto));
        $this->assertEquals(4000, $tarjeta->getSaldo());
        $this->assertEquals(0, $tarjeta->getCantViajesGratis());

        $this->assertEquals(True,$tarjeta->descontarFranquiciaCompleta($this->boleto));
        $this->assertEquals(3880, $tarjeta->getSaldo());
    }

    public function testViajesGratisDespuesDeUnNuevoDia() 
    {
        $inicio = strtotime('today'); // Fecha y hora inicial
        $tiempo = new tiempoFalso($inicio);
        $tarjeta = new franquiciacompleta(1,$tiempo); 
        $tiempo->avanzar(3600*7);

        // Realizar dos viajes gratuitos en un día
        $this->assertTrue($tarjeta->descontarFranquiciaCompleta(0)); // Primer viaje gratis
        $this->assertTrue($tarjeta->descontarFranquiciaCompleta(0)); // Segundo viaje gratis
        $this->assertEquals(0, $tarjeta->getCantViajesGratis());

        // Simular un nuevo día
        $tiempo->avanzar(86400); // Avanzar un día 

        // Realizar un viaje en el nuevo día (debe ser gratis nuevamente)
        $this->assertTrue($tarjeta->descontarFranquiciaCompleta(0)); // Tercer viaje gratis
    }

    public function testViajar23Horas()
    {
        $tiempo = new TiempoFalso;

        $tarjeta = new franquiciacompleta(1,$tiempo); 
        $tarjeta->recargar(2000);
        $tiempo->avanzar(3600*7);

        $this->assertTrue($tarjeta->descontarFranquiciaCompleta($this->boleto));    // Viaje 1
        $this->assertEquals(1, $tarjeta->getCantViajesGratis());
        $this->assertEquals(2000, $tarjeta->getSaldo());
        $tiempo->avanzar(3600*16);

        $this->assertTrue($tarjeta->descontarFranquiciaCompleta($this->boleto));    // Viaje 1
        $this->assertEquals(2000- $this->boleto, $tarjeta->getSaldo());
        $this->assertTrue($tarjeta->descontarFranquiciaCompleta($this->boleto));    // Viaje 1
        $this->assertEquals(1, $tarjeta->getCantViajesGratis());
    }
}

