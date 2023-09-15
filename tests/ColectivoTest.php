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
        $tarjeta = new tarjeta();

        $saldo = $tarjeta->saldo;

        $Boleto = 120;

        $tarjeta->pagar($Boleto);

        $this->assertEquals($saldo - $Boleto, $tarjeta->saldo);
    }
}