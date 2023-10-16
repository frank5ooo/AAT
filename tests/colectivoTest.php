<?php

namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\tarjeta;
use TrabajoSube\tiempoFalso;
use TrabajoSube\Colectivo;


class colectivoTest extends TestCase {

    public function testDescontar()
    {   
        $colectivo = new Colectivo(144);

        $tiempo = new TiempoFalso;

        $tarjeta = new Tarjeta(1,$tiempo);

        $tarjeta->recargar(1000);

        $precio = $colectivo->getPrecio();
        
        $colectivo->pagarCon($tarjeta);

        $this->assertEquals(1000-$precio,$tarjeta->getSaldo());
    }

}
?>
