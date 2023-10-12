<?php
namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\tarjeta;
use TrabajoSube\colectivo;
use TrabajoSube\boleto;
use TrabajoSube\franquiciacompleta;
use TrabajoSube\medioboleto;
use TrabajoSube\tiempoFalso;


 class FranquiciaCompletaTest extends TestCase {
    private $montosValidos = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 
    800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 
    2500, 3000, 3500, 4000];


    private $boleto = 120;


public function testPagarConFranquiciaCompleta()
    {
        $tiempo = new TiempoFalso;
        foreach ($this->montosValidos as $prueba){
            $tarjeta = new FranquiciaCompleta($tiempo);
            $tarjeta->recargar($prueba);

            $resultado = $tarjeta->descontar($this->boleto);

            $this->assertTrue($resultado);
            $this->assertEquals($prueba, $tarjeta->getSaldo());
        }
 
    }

}

?>