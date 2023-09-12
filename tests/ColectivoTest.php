<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

use TrabajoSube\tarjeta;

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