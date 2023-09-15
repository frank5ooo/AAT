<?php

namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\tarjeta;
use TrabajoSube\colectivo;
use TrabajoSube\boleto;
use Exception;

class ColectivoTest extends TestCase {

    public function testPagarBoleto()
    {
        $tarjeta = new tarjeta(200);

        $saldo = $tarjeta->saldo;

        $Boleto = $colectivo->pagarCon($tarjeta);

        $this->assertEquals($saldo - $Boleto, $tarjeta->saldo);
    }
}