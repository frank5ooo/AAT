<?php

namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\Tarjeta;
use TrabajoSube\Colectivo;
use TrabajoSube\Boleto;
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