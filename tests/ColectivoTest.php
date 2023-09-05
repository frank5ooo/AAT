<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {

    public function testPagarBoleto()
    {
        $tarjeta = new Tarjeta();

        $saldo = $tarjeta->saldo;

        $Boleto = 120;

        $tarjeta->pagar($Boleto);

        $this->assertEquals($saldo - $Boleto, $tarjeta->saldo);
    }
}
